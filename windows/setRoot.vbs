Dim fso, fo, fr, file_name, file_name_result, re, path

Set fso = WScript.CreateObject("Scripting.FileSystemObject")
Set file = Fso.GetFile(Wscript.ScriptFullName)
Set projectFolder = file.ParentFolder.ParentFolder

basePath = projectFolder.ParentFolder.Path
envFilePath = projectFolder.Path & "\.env"

If (fso.FileExists(envFilePath)) Then
	set textStream = fso.OpenTextFile(envFilePath)
	text = textStream.ReadAll()
    nginxPort = getEnvVar("NGINX_PORT", text)
Else
MsgBox ".env file not exists"
wscript.quit 9
End If

file_name_result = basePath & "\lib\nginx\conf\site.conf"
file_name = file_name_result & ".orig"
If (fso.FileExists(file_name_result)) Then
    fso.DeleteFile(file_name_result)
End If

Set fo = fso.OpenTextFile(file_name, 1, false, false)
Set fr = fso.OpenTextFile(file_name_result, 2, true, false)

Set objRegExp = CreateObject("VBScript.RegExp")
objRegExp.Global = true
objRegExp.Pattern = "\\"
publicPath = objRegExp.Replace(basePath, "\\")
objRegExp.Pattern = "WWW_ROOT"

Set portRegExp = CreateObject("VBScript.RegExp")
portRegExp.Global = true
portRegExp.Pattern = "NGINX_PORT"

Do While fo.AtEndOfStream = False
    line = fo.ReadLine()
    line_replace = objRegExp.Replace(line, publicPath)
    line_replace = portRegExp.Replace(line_replace, nginxPort)
    fr.WriteLine(line_replace)
Loop

fo.Close()
fr.Close()

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

wscript.quit 0
