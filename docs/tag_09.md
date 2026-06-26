# Tag 9 (25.06.2026)

## Was ich heute geschafft habe:

- Heute habe ich die Navigation aufgeräumt. Ich habe den nicht funktionierenden "Benutzer"-Link entfernt und die doppelte Dateistruktur auf dem Server bereinigt. Dadurch wird jetzt die richtige Navigationsleiste geladen.

- Ausserdem habe ich die Farbe des Admin-Buttons "Produkte verwalten" angepasst. Der Button ist jetzt pink und passt besser zum Streetwear-Design des Shops.

- Danach habe ich den Fehler bei der Bestellzeit behoben. Das Bestellskript speichert jetzt die richtige Schweizer Uhrzeit in der Datenbank. Neue Bestellungen haben nun die korrekte Zeit.

## Was gut lief:

Nachdem ich die doppelte Datei gefunden hatte, konnte ich die Navigation schnell korrigieren. Auch die Anpassung der Zeitzone hat gut funktioniert und die Daten werden jetzt richtig in der SQLite-Datenbank gespeichert.

## Schwierigkeiten und Lösungen:

Obwohl ich die **navbar.php** im **includes**-Ordner geändert hatte, wurde auf der Webseite immer noch die alte Navigation angezeigt. Der Grund war, dass sich im Hauptordner noch eine alte Version der Datei befand, die stattdessen geladen wurde.

Ich habe die alte Datei gelöscht und den Pfad angepasst, sodass jetzt die richtige **navbar.php** verwendet wird.

Ein weiteres Problem war, dass Bestellungen immer zwei Stunden zu früh gespeichert wurden. Das lag daran, dass SQLite standardmaessig die Weltzeit verwendet. Ich habe die Zeitzone in der **place_order.php** auf **Europe/Zurich** gesetzt und die Uhrzeit direkt in PHP erstellt. Diese wird jetzt beim Speichern der Bestellung mitgeschickt.

## Plan für den nächsten Tag:

Morgen werde ich das ganze Projekt noch einmal testen, den Code aufräumen und mit der Projektdokumentation fertig werden. Danach ist das Abschlussprojekt bereit zur Abgabe.
