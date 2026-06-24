# Tag 7 (19.06.2026)

## Was ich heute geschafft habe:

- Issue #26 (Bestellübersicht für Admin) umgesetzt: Ich habe das Admin-Dashboard gestartet. Das Skript lädt alle eingegangenen Bestellungen aus der orders-Tabelle, sodass der Admin sofort sieht, welcher User was gekauft hat.

- Issue #7 & #8 (Admin-Produkte CRUD) fertiggestellt: Ich habe die Formulare für den Admin-Bereich gebaut. Der Admin kann jetzt neue Produkte direkt über die Website-Oberfläche hinzufügen und alte oder falsche Produkte mit einem Klick wieder löschen.

- Issue #5 (Rollen-System & Seitenschutz) abgesichert: Ich habe die Admin-Seiten mit einer Sicherheitsabfrage versehen. Das System prüft nun ab, ob der eingeloggte User die Rolle admin hat. Normale Kunden werden blockiert und weggeschickt.

- Issue #16 & #17 (Empfehlungslogik & Anzeige) eingebaut: Ich habe den Code für die Produktempfehlungen geschrieben. Das Skript erkennt die Farbe des aktuell angezeigten Produkts und sucht automatisch andere Artikel mit derselben Farbe aus der Datenbank heraus, die dann dem Kunden als Vorschlag angezeigt werden.

## Was gut lief:

Der Home-Office-Tag war produktiv. Dadurch, dass ich richtig ungestört durcharbeiten konnte, habe ich alle geplanten Issues für das Admin-Dashboard und die Farb-Empfehlungen ohne grosse Verzögerungen geschafft. Die Logik für die Produktempfehlungen hat auch sofort auf Anhieb funktioniert.

## Schwierigkeiten und Lösungen:

Verwirrung bei den Absendezeiten im Homeoffice: Ich habe unabsichtlich eine Statusnachricht über Slack eine Stunde zu früh an meinen Coach abgeschickt, was kurz für Verwirrung gesorgt hat...

**Die Lösung:** Ich habe den Fehler direkt mit einer kurzen Nachricht aufgeklärt und die Kommunikation danach wieder exakt nach den vorgegebenen Touchpoints und Zeiten des ZLI weitergeführt.

## Plan für den nächsten Tag:

Mit dem heutigen Tag ist auch Milestone 3 fast komplett fertig. Morgen an Tag 8 geht es an den Feinschliff: Ich mache einen grossen Sicherheits-Check (Issue #1) für den Code, füge noch ein paar finale Testdaten hinzu und fangen mit dem grossen manuellen Testing (Kunden-Flow und Admin-Flow) an, um alle restlichen Fehler zu finden.