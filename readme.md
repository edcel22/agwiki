#build docker image
docker-compose up -d

#open mysql terminal
docker exec -it mysql_container /bin/bash


#import db
docker cp beta2agw_sql.sql mysql_container:/db.sql
mysql -u mysql_root -p agwiki < db.sql
