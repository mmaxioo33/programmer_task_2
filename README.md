Instrukcja uruchomienia aplikacji
========================

Wymagania:
* PHP: 7.2.*
--------------
Framework:
* Symfony w wersji 3.4.*

 Wykonaj poniższe kroki aby uruchomić aplikacje i wyświetlić uzyskany rezultat
  * Otwórz konsole
  * Pobierz projekt z repozytorium github: [programmer_task_2][1]
  * Przejdź do folderu w którym znajduje sie projekt
  * W konsoli wywołaj polecenie `composer install` 
  (pod koniec instalacjii podaj poprawne dane do połączenia z bazą danych, pomiń kwestnie mailera wciskając enter)
  * Następnie uruchom polecenia według podanej kolejności:
    * `php bin/console d:m:diff`
    * `php bin/console d:m:migrate` (zatwierdz wpisując "y")
  * Na koncu wykonaj polecenie `php bin/console s:r`
  * Po uruchomieniu lokalnego serwera wchodzimy na bazową stronę: http://127.0.0.1:8000


[1]:  https://github.com/mmaxioo33/programmer_task_2
