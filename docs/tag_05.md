# Tag 5 (17.06.2026)

## Was ich heute geschafft habe:

- Issue #11 (Produktanzeige auf der Startseite) gelöst: Ich habe die index.php so umgebaut, dass die Produkte (Sneaker, Hoodie, Cap) dynamisch via PDO aus der SQLite-Datenbank ausgelesen und in einem sauberen CSS-Grid auf der Startseite angezeigt werden.

- Datenbank-Setup angepasst (setup_db.php): Ich habe das Setup-Skript erweitert, damit die Produktbilder nicht mehr von externen Unsplash-Links geladen werden (was zu Ladefehlern führte), sondern direkt als lokale Bildpfade (images/) in der Datenbank gespeichert werden.

- Registrierung überarbeitet (register.php): Ich habe die Struktur der Registrierungsseite aufgeräumt, den doppelten HTML-Head entfernt, der das CSS blockiert hat, und einen dynamischen Weiterleitungs-Button zur Login-Seite eingebaut, der nach einer erfolgreichen Registrierung erscheint.

- Issue #12 (Produkt-Detailseite) erstellt: Ich habe die neue Datei product_detail.php gebaut. Wenn ein Kunde auf ein Produkt klickt, wird die ID über die URL übergeben und das Skript lädt exakt dieses Produkt mit Beschreibung, großem Bild und einem Formular für den Warenkorb.

## Was gut lief:

- Das lokale Laden der Bilder über den eigenen Server hat das Problem mit den blockierten Unsplash-Links sofort gelöst. Auch die Logik der Produkt-Detailseite hat auf Anhieb funktioniert und zieht sich die richtigen IDs fehlerfrei aus der Datenbank.

## Schwierigkeiten und Lösungen:

- Doppelte Navbar & CSS-Ausfälle: Auf der Startseite und bei der Registrierung war plötzlich die Navigation doppelt zu sehen und das Design zerschossen.

**Die Lösung:** Ich habe festgestellt, dass die Navbar sowohl im Header als auch in den einzelnen Seiten aufgerufen wurde. Ich habe das doppelte include aus den Seiten gelöscht. Zudem gab es Probleme mit dem Browser-Cache, da InfinityFree Änderungen an der CSS-Datei nur verzögert anzeigt. Ein "Hard Refresh" (Strg + F5) hat das Design letztendlich wieder gut gemacht.

- Fehlende Sneaker-Bilder (404-Fehler): Das Hoodie- und das Cap-Bild wurden geladen, aber der Sneaker zeigte einen Fehler an.

**Die Lösung:** Ich habe den Pfad und die Gross-/Kleinschreibung im Dateimanager geprüft. Nach einem erneuten, sauberen Upload der Datei direkt in den images/-Ordner auf dem Server war auch der Sneaker sichtbar.

## Plan für den nächsten Tag:

Als Nächstes starte ich mit Issue #13 und kümmere mich um die Warenkorb-Logik (add_to_cart.php), damit die ausgewählten Produkte auch wirklich für den jeweiligen Benutzer in der Datenbank zwischengespeichert werden können.