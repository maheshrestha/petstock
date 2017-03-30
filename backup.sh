# Database credentials
 user="root"
 password=""
 host="localhost"
 db_name="perstock"

 backup_path="/opt/backups/database"
 date=$(date +"%d-%b-%Y")

 # Set default file permissions
  umask 177
 # Dump database into SQL file
  mysqldump --user=$user --password=$password --host=$host $db_name > $backup_path/$db_name-$date.sql
