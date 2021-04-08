Set fso = WScript.CreateObject("Scripting.FileSystemObject")
Set file = Fso.GetFile(WScript.ScriptFullName)
Set projectFolder = file.ParentFolder.ParentFolder

rawBasePath = projectFolder.ParentFolder.Path

rawPgsqlPath = rawBasePath & "\lib\pgsql\bin"
pgctlPath = updatePath(rawPgsqlPath & "\pg_ctl.exe")
dbData = updatePath(rawBasePath & "\data\db")
logPath = updatePath(rawBasePath & "\log\pg_run_log.log")

Set Shell= WScript.CreateObject("WScript.Shell")

'WScript.Echo "Starting PostgreSQL..."
Shell.Run pgctlPath & " -D " & dbData & " -l " & logPath & " start", 0, true

Function updatePath(ByVal path)

 set re = CreateObject("VBScript.RegExp")
 re.Pattern = "\s"

 If (re.test(path)) Then
    path = """" & path & """"
 End If

 updatePath = path
End Function