Set fso = WScript.CreateObject("Scripting.FileSystemObject")
Set file = Fso.GetFile(WScript.ScriptFullName)
Set projectFolder = file.ParentFolder.ParentFolder

rawProjectPath = projectFolder.Path
rawBasePath = projectFolder.ParentFolder.Path
projectPath = updatePath(rawProjectPath)
basePath = updatePath(rawBasePath)


Set Shell= WScript.CreateObject("WScript.Shell")

'WScript.Echo "Starting NGINX...\n"
nginxPath = updatePath(rawBasePath & "\lib\nginx")
Shell.Run "cmd /c cd " & nginxPath & " && nginx.exe", 0, False

'WScript.Echo "Starting Redis...\n"
redisPath = updatePath(rawBasePath & "\lib\redis\redis-server.exe")
Shell.Run redisPath, 0, False

'WScript.Echo "Starting PHP...\n"
phpCgiPath = updatePath(rawBasePath & "\lib\php7.4\php-cgi.exe")
Shell.Run phpCgiPath & " -b 127.0.0.1:9000", 2, False

'WScript.Echo "Starting queue...\n"
'Shell.Run phpPath & " " & projectPath & "\artisan queue:work --queue=images", 2, False

Function updatePath(ByVal path)

 set re = CreateObject("VBScript.RegExp")
 re.Pattern = "\s"

 If (re.test(path)) Then
 	path = """" & path & """"
 End If

 updatePath = path
End Function
