if ((Get-PSSnapin -Name VeeamPSSnapIn -ErrorAction SilentlyContinue) -eq $null) {
    Add-PsSnapin -Name VeeamPSSnapIn
}

$servers = @("MON-VEEAM-1", "MON-VEEAM-2", "MON-VEEAM-3", "MON-VEEAM-4", "MON-VEEAM-5", "MON-VEEAM-6", "MON-VEEAM-7", "MON-VEEAM-8", "MON-VEEAM-9", "MON-VEEAM-10", "MON-VEEAM-11", "MON-VEEAM-12")

foreach ($server in $servers) {
    Connect-VBRServer -User DOMAINE\simonfalicon -Password mon_super_password -Server $server

    foreach($Job in (Get-VBRJob))
       {
        if ($job.IsBackup) {
            $Session = $Job.FindLastSession()
            if(!$Session){continue;}
            $Info = $Session.GetTaskSessions()

            $VM = ($info | ForEach-Object {$_} |
                Where-Object {$_.status -eq "InProgress" -or $_.status -eq "Pending" -or $_.status -eq "Success" -or $_.status -eq "Failed"}) |
                Foreach-object {$_ | select @{Expression={$_.Name}},@{Expression={$server}},@{Expression={$_.Status}} | Format-table -HideTableHeaders | out-file vm-temp.txt -Append -encoding UTF8}
            }
       }

    Disconnect-VBRServer
}

$list = Get-Content vm-temp.txt | where { $_ -ne "$null" }
$list | foreach { $_ -replace '\s+', ' ' } | out-file vm.txt -Append -encoding UTF8
vm-temp.txt

ftp -s:C:\Script\ftpcmd.dat
sleep 5
rm vm.txt
