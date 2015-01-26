# Teryt ZF2 module

Aktualne pliki z bazą danych ulic i miejscowości pobieramy ze strony:
	
http://www.stat.gov.pl/broker/access/prefile/listPreFiles.jspa
	
Należy pobrać:
- katalog miejscowości (SIMC)
- katalog ulic (ULIC)

Pliki umieszczamy w katalogu z aplikacją, w podkatalogu:
	
/tmp/gus
	
Następnie rozpakowujemy (w tym samym katalogu):
	
unzip SIMC_ddmmyyyy.zip
unzip ULIC_ddmmyyyy.zip
	
Przechodzimy do katalogu:
	
scripts
	
i uruchamiamy skrypt:
	
actualize_gus.sh
	
Skrypt wykonuje się ok. 30 minut.
	
W wyniku wywołania skryptu w katalogu:

/tmp/gus
	
utworzą się pliki streets.sql i districts.sql.

Należy je zaimportować do bazy danych 3rd_party. W celu usunięcia już istniejących danych z tabelek street i district można posłużyć się skryptem

create_tables_3rd_party.sh

w katalogu:

sql