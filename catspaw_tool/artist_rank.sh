#!/bin/bash
PATH=/bin:/usr/bin:/sbin:/usr/sbin:/usr/local/bin

#------------------------------------------------
# mysql variables
#------------------------------------------------
MYSQL_USER='field-jack'
MYSQL_PASSWORD='korogarubuta343'
MYSQL_HOST='mysql621.db.sakura.ne.jp'
MYSQL_DATABASE='field-jack_wp1'
# 以下に実行したいsql文を書く

#MYSQL_SQL =	"SET @a = 0; UPDATE cats_usermeta SET artist_rank = (@a :=@a+1) WHERE \`meta_key\` = 'artist_point' ORDER BY \`meta_value\` DESC;"

eval "/usr/local/bin/mysqldump -h $MYSQL_HOST -u $MYSQL_USER -p $MYSQL_DATABASE --password='$MYSQL_PASSWORD' > ~/field-jack-backup.sql"
mysql -h $MYSQL_HOST -u $MYSQL_USER -p$MYSQL_PASSWORD $MYSQL_DATABASE --default-character-set=utf8 << EOF

SET @a = 0; UPDATE cats_usermeta SET artist_rank = (@a :=@a+1) WHERE \`meta_key\` = 'artist_point' ORDER BY \`meta_value\` DESC;

EOF