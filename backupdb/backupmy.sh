#!/bin/bash
for db in $(mysql -u root  -e "SHOW DATABASES;" | grep -Ev "(Database|information_schema|performance_schema|mysql|sys)")
do
  mysqldump --single-transaction --routines --triggers -u root  "$db" | gzip > "$db.sql.gz"
done
