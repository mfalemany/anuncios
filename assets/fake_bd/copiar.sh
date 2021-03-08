#Me posiciono sobre el directorio que contiene el archivo a copiar
cd /mnt/datos/vhosts/agr/www/anuncios/assets/fake_bd/
fecha=$(date +%Y%m%d_%H)

cp publicaciones.json backup/publicaciones$fecha.json
cp turno_examenes.json backup/turno_examenes$fecha.json

curl -X PUT -u falemany:Federico1918 -k --data-binary @"publicaciones.json" "https://docs.unne.edu.ar/remote.php/webdav/backups_agrarias/anuncios/publicaciones$fecha.json"
curl -X PUT -u falemany:Federico1918 -k --data-binary @"turno_examenes.json" "https://docs.unne.edu.ar/remote.php/webdav/backups_agrarias/anuncios/turno_examenes$fecha.json"
