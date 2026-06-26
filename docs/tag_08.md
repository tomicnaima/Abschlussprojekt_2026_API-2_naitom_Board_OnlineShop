# Tag 8 (24.06.2026)

## Was ich heute geschafft habe:

- Heute habe ich mit dem grossen manuellen Testing begonnen. Ich habe den ganzen Kundenablauf getestet, also Registrierung, Login, Produkte anschauen, Warenkorb und Kasse. Ausserdem habe ich auch den Admin-Bereich getestet, vor allem die Produktverwaltung.

- Danach habe ich über die Produktverwaltung neue Testprodukte hinzugefügt. Dazu gehören ein Nike Sport-Bra, Nike Shorts, eine Streetwear Cap und Adidas Samba Sneaker. Ich habe auch kurze Beschreibungen für die Produkte geschrieben.

- Beim Testen sind mir einige Fehler aufgefallen. Die Produktbilder wurden auf der Startseite und im Warenkorb nicht angezeigt. Ausserdem wurde nach dem Login immer die Rolle "customer" angezeigt, obwohl der Benutzer in der Datenbank als Admin gespeichert war.

## Was gut lief:

Das Hinzufügen der neuen Produkte über den Admin-Bereich hat ohne Probleme funktioniert. Alle Daten wurden richtig in der SQLite-Datenbank gespeichert, sodass ich das Sortiment einfach erweitern konnte.

## Schwierigkeiten und Lösungen:

Die Produktbilder wurden nicht angezeigt, weil im Code nach der falschen Datenbankspalte gesucht wurde. Statt image_url heisst die Spalte einfach image. Beim Dashboard war die Rolle direkt im HTML eingetragen und wurde deshalb nicht aus der Datenbank übernommen.

Ich habe den Code in der **index.php** und **cart.php** angepasst, sodass jetzt die richtige Spalte verwendet wird und die Bilder wieder angezeigt werden. Im Dashboard habe ich die feste Rollenanzeige durch eine Session-Abfrage ersetzt. Jetzt wird die richtige Benutzerrolle angezeigt.

## Plan für den nächsten Tag:

Morgen möchte ich die letzten Fehler beheben. Ich werde den nicht funktionierenden Benutzer-Link in der Navigation entfernen, die falsche Server-Uhrzeit auf die Schweizer Zeitzone anpassen und die doppelte *navbar.php*-Dateistruktur aufräumen.
