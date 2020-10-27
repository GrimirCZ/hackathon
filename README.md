# Backend aplikace Hlídač spojů

Tento repozitář obsahuje backendovou část aplikace [Hlídač spojů](https://zpozdeni.puhony.eu/) vytvořenou na [Open Data Hackathon Královehradeckého Kraje](https://www.tchk.cz/akce/open-data-hackathon/). Backend má za úkol sledovat průběžná zpoždění, počítat průběžná zpoždění a sledovat návaznosti autobusových a vlakových linek. Backen je naprogramován v PHP za využití frameworku [Laravel](https://laravel.com).

## Výčet technologii

- MySQL
  - Databázový server
- Laravel + PHP
  - Webserver + runtime
- Linux + Nginx + Cron
  - Prostředí
 
 ## Seznam otevřených dat
 
 - [Čekací doby autobusových linek](http://www.kr-kralovehradecky.cz/scripts/detail.php?id=113947)
   - návaznosti linek
 - [Spoždění a pozice](http://tabule.oredo.cz/idspublicservices/api/service/position)
   - realtime data
   
 ## Jak zprovoznit
 
 - Vytvořit server
 - [Sprovoznit server](https://www.digitalocean.com/community/tutorials/how-to-deploy-a-laravel-application-with-nginx-on-ubuntu-16-04)
 - [Nastavit cron](https://laravel.com/docs/8.x/scheduling#starting-the-scheduler)
 - [Nastavit doménu](https://help.wedos.cz/navody/webhosting/prace-s-dns-zaznamy-1-zakladni-zaznamy/)
