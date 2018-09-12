strFilename = "data\test.json"

Set objFSO = CreateObject("Scripting.FileSystemObject")
Set objFSO = CreateObject("Scripting.FileSystemObject")
Set objFile = objFSO.OpenTextFile(strFilename, 1)
intLineNum = 1
msgbox "Starting Reading " & strFilename
Do While objFile.AtEndOfStream = False
    strLine = objFile.ReadLine

    intLineLen = len(strLine)
    if intLineLen > 2 then
        if intLineLen <  50 then
            if Mid(strLine, intLineLen - 2) <> "[]}" then
                msgbox "Check Line " & intLineNum
            end if
        else
            if Mid(strLine, intLineLen - 6) <> "}]}]}]}" then
                msgbox "Check Line " & intLineNum
            end if
        end if
    end if
    intLineNum = intLineNum +1
Loop

msgbox "File Checked (" & intLineNum-1 & "Lines)"