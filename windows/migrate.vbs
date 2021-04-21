Set fso = WScript.CreateObject("Scripting.FileSystemObject")
Set file = Fso.GetFile(WScript.ScriptFullName)
Set projectFolder = file.ParentFolder.ParentFolder

rawProjectPath = projectFolder.Path
rawBasePath = projectFolder.ParentFolder.Path

projectPath = updatePath(rawProjectPath)
basePath = updatePath(rawBasePath)
phpPath = updatePath(rawBasePath & "\lib\php7.4\php.exe")

Set Shell= WScript.CreateObject("WScript.Shell")
'apply migrations
Shell.Run "cmd /c cd " & projectPath & " && " & phpPath & " artisan migrate", 2, true
MsgBox "Migration is successful"

Function updatePath(ByVal path)

 set re = CreateObject("VBScript.RegExp")
 re.Pattern = "\s"

 If (re.test(path)) Then
    path = """" & path & """"
 End If

 updatePath = path
End Function


wscript.quit 0
