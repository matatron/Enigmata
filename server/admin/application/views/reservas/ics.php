BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//www.enigmata.co.cr//iCal Event
CALSCALE:GREGORIAN
BEGIN:VTIMEZONE
TZID:America/Costa_Rica
LAST-MODIFIED:<?=gmdate('Ymd').'T'. gmdate('His');?>Z
TZURL:https://www.tzurl.org/zoneinfo-outlook/America/Costa_Rica
X-LIC-LOCATION:America/Costa_Rica
BEGIN:STANDARD
TZNAME:CST
TZOFFSETFROM:-0600
TZOFFSETTO:-0600
DTSTART:19700101T000000
END:STANDARD
END:VTIMEZONE
BEGIN:VEVENT
DTSTAMP:<?=gmdate('Ymd').'T'. gmdate('His');?>Z
UID:<?=$id;?>@enigmata.co.cr
ORGANIZER;CN=Enigmata Escape Room:mailto:gerencia@enigmata.co.cr
DTSTART;TZID=America/Costa_Rica:<?=$fecha;?>T<?=$inicio;?>00
DTEND;TZID=America/Costa_Rica:<?=$fecha;?>T<?=$final;?>00
SUMMARY:Enigmata Escape Room
DESCRIPTION:Reserva en Enigmata Escape Room a nombre de <?=$name;?> para <?=$people; ?> personas
LOCATION:Enigmata Escape Room\, Heredia Centro\, 75 mts Norte de Asembis
END:VEVENT
END:VCALENDAR