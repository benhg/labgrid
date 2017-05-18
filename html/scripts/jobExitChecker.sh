#!/bin/bash

condor_history | sed -n '1!p' > history.txt

rm /var/lib/condor/spool/history*
touch /var/lib/condor/spool/history
chmod 777 /var/lib/condor/spool/history

while read line; do
    echo "Loop"
    condor_id=""
    owner=""
    submit_date=""
    submit_time=""
    runtime=""
    job_status=""
    completed_date=""
    completed_time=""
    command_file=""
    i=0
    for word in $line
    do
        if [ "$i" -eq 0 ]
        then 
           condor_id=$word
        elif [ "$i" -eq 1 ]
        then
            owner=$word
        elif [ "$i" -eq 2 ]
        then 
            submit_date=$word
        elif [ "$i" -eq 3 ]
        then
            submit_time=$word
        elif [ "$i" -eq 4 ]
        then
            runtime=$word
        elif [ "$i" -eq 5 ]
        then
            job_status=$word
            if [ "$job_status" = "X" ]
            then
                break
            fi
        elif [ "$i" -eq 6 ]
        then
            completed_date=$word
        elif [ "$i" -eq 7 ]
        then
            completed_time=$word
        elif [ "$i" -eq 8 ]
        then
            command_file=$word
        fi
        ((i=i+1))
    done
    if [ "$job_status" = "X" ]
    then
        continue
    fi
    echo $command_file
    directories=$(echo $command_file | tr "/" "\n")
    check_next=0
    job_dir=""
    for directory in $directories
    do
        if [ $directory == "dropbox" ]
        then        
            check_next=1
        elif [ "$check_next" -eq 1 ]
        then
            job_dir=$directory
            break
        fi
    done
    job_name="${job_dir%_*}" 
    targetfile_base=$(echo "$command_file" | sed 's/\.[ ^. ]*$//')
    targetfile=$targetfile_base".out"
    mysql -u root -pbakersdozen -D labgrid -e "UPDATE jobs SET status=1 WHERE condor_id="$condor_id
    echo $owner
    echo $condor_id
    echo $job_name

    username=$(mysql -u root -pbakersdozen -D labgrid -se "SELECT username FROM jobs WHERE condor_id="$condor_id)
    echo $username
    php /var/www/html/scripts/email.php $username $condor_id $job_name $job_dir
done < ./history.txt

~                                                                                                                                                                                                                                                                                                     
~                                                                                                                                                                                                                                                                                                     
~                                                                                                                                                                                                                                                                                                     
~           
