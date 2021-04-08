Set fso = WScript.CreateObject("Scripting.FileSystemObject")
Set file = Fso.GetFile(WScript.ScriptFullName)
Set projectFolder = file.ParentFolder.ParentFolder

rawProjectPath = projectFolder.Path
rawBasePath = projectFolder.ParentFolder.Path
projectPath = updatePath(rawProjectPath)
basePath = updatePath(rawBasePath)

Set Shell= WScript.CreateObject("WScript.Shell")

'WScript.Echo "Stopping NGINX...\n"
nginxPath = updatePath(rawBasePath & "\lib\nginx")
Shell.Run "cmd /c cd " & nginxPath & " && nginx.exe -s stop", 0, false

'WScript.Echo "Stopping Redis...\n"
redisPath = updatePath(rawBasePath & "\lib\redis")
Shell.Run "cmd /c cd " & redisPath & " && redis-cli.exe shutdown", 2, false

Function updatePath(ByVal path)

 set re = CreateObject("VBScript.RegExp")
 re.Pattern = "\s"

 If (re.test(path)) Then
 	path = """" & path & """"
 End If

 updatePath = path
End Function
