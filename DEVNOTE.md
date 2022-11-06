# Dev Note

## Command Note

### Schema

```bash
./mysqldump -u root -p courier_db > ~/Documents/courier_db.sql
```

### Spesific table

```bash
./mysqldump -u root -p courier_db table > ~/Documents/courier_db.sql
```

### Spesific table wo data

```bash
./mysqldump -d -u root -p courier_db table > ~/Documents/courier_db.sql
```

### Spesific table wo data

```bash
./mysqldump --no-create-info -u root -p courier_db table > ~/Documents/courier_db.sql
```