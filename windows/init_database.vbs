Set fso = WScript.CreateObject("Scripting.FileSystemObject")
Set file = Fso.GetFile(WScript.ScriptFullName)
Set projectFolder = file.ParentFolder.ParentFolder

rawProjectPath = projectFolder.Path
rawBasePath = projectFolder.ParentFolder.Path

projectPath = updatePath(rawProjectPath)
basePath = updatePath(rawBasePath)
envFilePath = rawProjectPath & "\.env"
phpPath = updatePath(rawBasePath & "\lib\php7.2\php.exe")

rawPgsqlPath = rawBasePath & "\lib\pgsql\bin"
dbData = updatePath(rawBasePath & "\data\db")
logPath = updatePath(rawBasePath & "\log\pg_run_log.log")

Set Shell= WScript.CreateObject("WScript.Shell")

If (fso.FileExists(envFilePath)) Then
	set textStream = fso.OpenTextFile(envFilePath)
	text = textStream.ReadAll()

    dbUsername = getEnvVar("SECUROS_DASHBOARD_DB_DATABASE", text)
    dbPassword = getEnvVar("SECUROS_DASHBOARD_DB_PASSWORD", text)
    dbName = getEnvVar("SECUROS_DASHBOARD_DB_DATABASE", text)

    'init db
    initdbPath = updatePath(rawPgsqlPath & "\initdb.exe")
    pgctlPath = updatePath(rawPgsqlPath & "\pg_ctl.exe")
    createdbPath = updatePath(rawPgsqlPath & "\createdb.exe")
    createuserPath = updatePath(rawPgsqlPath & "\createuser.exe")
    psqlPath = updatePath(rawPgsqlPath & "\psql.exe")


    Shell.Run initdbPath & " -U root -E UTF-8 -D " & dbData, 2, true
    Shell.Run pgctlPath & " -D " & dbData & " -l " & logPath & " start", 2, true
    Shell.Run createdbPath & " -U root " & dbName, 2, true
    Shell.Run createuserPath & " -U root " & dbUsername, 2, true
    Shell.Run psqlPath & " -U root -d " & dbName & " -c ""ALTER USER " & dbUsername & " PASSWORD '" & dbPassword & "';""", 2, false
    Shell.Run psqlPath & " -U root -d " & dbName & " -c ""GRANT CONNECT ON DATABASE " & dbName & " TO " & dbUsername & ";""", 2, true
    Shell.Run psqlPath & " -U root -d " & dbName & " -c ""GRANT USAGE ON SCHEMA public TO " & dbUsername & ";""", 2, true
    Shell.Run psqlPath & " -U root -d " & dbName & " -c ""GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA public TO " & dbUsername & ";""", 2, true
    Shell.Run psqlPath & " -U root -d " & dbName & " -c ""GRANT ALL PRIVILEGES ON ALL SEQUENCES IN SCHEMA public TO " & dbUsername & ";""", 2, true

    'stop postgresql
    Shell.Run pgctlPath & " -D " & dbData & " -l " & logPath & " stop", 2, true

    MsgBox "Database initialization is successful"

Else
MsgBox ".env file not exists"
wscript.quit 9
End If

Function getEnvVar(ByVal name, ByVal text)
    Set objRegExp = CreateObject("VBScript.RegExp")
    objRegExp.Pattern = "(" & name & "=)\w+"
    Set objMatches = objRegExp.Execute(text)

    If (objMatches.count = 0) Then
       MsgBox name & " not set in .env file"
       wscript.quit 9
    End If

    Set objMatch = objMatches.Item(0)
    start = Len(name) + 2
    length = objMatch.Length - (Len(name) + 1)
    getEnvVar = mid(objMatch.value, start, length)
End Function

Function updatePath(ByVal path)

 set re = CreateObject("VBScript.RegExp")
 re.Pattern = "\s"

 If (re.test(path)) Then
    path = """" & path & """"
 End If

 updatePath = path
End Function


wscript.quit 0
