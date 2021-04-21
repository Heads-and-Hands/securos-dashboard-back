Set fso = WScript.CreateObject("Scripting.FileSystemObject")
Set file = Fso.GetFile(WScript.ScriptFullName)
Set projectFolder = file.ParentFolder.ParentFolder

rawProjectPath = projectFolder.Path
rawBasePath = projectFolder.ParentFolder.Path
projectPath = updatePath(rawProjectPath)
basePath = updatePath(rawBasePath)

Set Shell= WScript.CreateObject("WScript.Shell")

'generate application key
phpPath = updatePath(rawBasePath & "\lib\php7.4\php.exe")
Shell.Run "cmd /c cd " & projectPath & " && " & phpPath & " artisan key:generate", 0, true

MsgBox "Key is generated"

Function updatePath(ByVal path)

 set re = CreateObject("VBScript.RegExp")
 re.Pattern = "\s"

 If (re.test(path)) Then
 	path = """" & path & """"
 End If

 updatePath = path
End Function
