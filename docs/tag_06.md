# Tag 6 (18.06.2026)

## Was ich heute geschafft habe:

- Issue #13 (In den Warenkorb-Logik) implementiert: Ich habe die add_to_cart.php geschrieben. Das Skript prüft, ob ein User eingeloggt ist, fängt die Produkt-ID sowie die Menge ab und speichert die Daten dynamisch in der Tabelle cart_items. Falls das Produkt schon im Warenkorb liegt, wird die Anzahl automatisch erhöht.

- Issue #14 (Warenkorb-Anzeige) gebaut: Ich habe die cart.php erstellt. Sie lädt über einen SQL-JOIN alle Produkte des angemeldeten Users aus der Datenbank, berechnet die Zwischensummen sowie die Gesamtsumme und stellt alles in einer übersichtlichen Tabelle dar.

- Issue #15 (Warenkorb-Löschfunktion) hinzugefügt: Ich habe die Datei remove_from_cart.php entwickelt und die cart.php um rote Löschen-Buttons erweitert. Nutzer können Artikel nun per Klick sicher und direkt aus ihrer Session/Datenbank entfernen.

- Issue #10, #12 (Warenkorb & Checkout) fertig: Ich habe die Kasse (checkout.php) mit einem Formular für die Lieferadresse aufgesetzt. Beim Abschicken verarbeitet die place_order.php den Kauf über eine sichere Datenbank-Transaktion: Sie erstellt eine Order in orders, kopiert die Artikel in order_items, leert den Warenkorb und gibt eine Erfolgsmeldung mit der Bestellnummer aus.

## Was gut lief:
Die gesamte Warenkorb und Bestell-Logik lief. Die Weiterleitungen zwischen Detailseite, Warenkorb und Kasse greifen perfekt ineinander und die mathematischen Berechnungen der Preise in PHP stimmen auf den Cent genau.

## Schwierigkeiten und Lösungen:
Sicherheitswarnung im Browser (Gefährliche Website): Google Chrome hat die Seite plötzlich mit einem großen roten Warnbildschirm blockiert, weil die unverschlüsselte Gratis-Domain (http://) in Kombination mit einem selbstgebauten Login-Formular für Phishing gehalten wurde.

**Die Lösung:** Für den Moment habe ich die Sperre über die erweiterten Details im Browser ("Trotzdem fortfahren") umgangen, um ungestört weiterzuarbeiten. Als dauerhafte Lösung werde ich als Nächstes das kostenlose SSL-Zertifikat im InfinityFree-Dashboard aktivieren, um die Seite auf sicheres https:// umzustellen.

## Plan für den nächsten Tag:
Milestone 2 ist komplett abgeschlossen! Am nächsten Tag starten wir mit Milestone 3 (Admin-Bereich & Bestellverwaltung). Ich werde mich darum kümmern, dass Admins neue Produkte über ein Dashboard hinzufügen und die eingegangenen Bestellungen der Kunden einsehen können.