# Abschlussprojekt 2026: 
# Naima's Shop – Entwicklung eines Onlineshops mit PHP und SQLite

## Individuelle Abschlussarbeit BLJ 2026

Autorin: Naima Tomic  
Lehrfirma: Webcraft
Projektzeitraum: Juni 2026

# Projektbeschreibung

Dieses Projekt wurde im Rahmen der individuellen Abschlussarbeit BLJ 2026 entwickelt.

Ziel des Projekts war die Entwicklung eines vollständigen und funktionsfähigen Onlineshops für Streetwear mit dem Namen **Naima's Shop**.

Der Onlineshop wurde mit PHP, SQLite, HTML und CSS umgesetzt. Die Anwendung verfügt über einen Benutzerbereich sowie einen separaten Administrationsbereich.

Benutzer können sich registrieren, anmelden, Produkte ansehen, Artikel in den Warenkorb legen und Bestellungen abschliessen.

Administratoren können Produkte verwalten und alle eingegangenen Bestellungen einsehen.

Während der Entwicklung wurde besonders auf eine saubere Struktur, sichere Datenverarbeitung und eine benutzerfreundliche Bedienung geachtet.

# Funktionen

## Benutzerbereich

Folgende Funktionen stehen normalen Benutzern zur Verfügung:

- Registrierung eines neuen Kontos
- Login und Logout
- Session-basierte Benutzerverwaltung
- Anzeige aller verfügbaren Produkte
- Produktdetailseite
- Produktempfehlungen
- Warenkorb
- Mengenverwaltung im Warenkorb
- Checkout-Prozess
- Speicherung von Bestellungen
- Übersicht der eigenen Bestellungen


## Administrator-Bereich

Administratoren verfügen über zusätzliche Rechte:

- Zugriff auf Dashboard
- Neue Produkte erstellen
- Produkte bearbeiten
- Produkte löschen
- Produktinformationen verwalten
- Alle Bestellungen aller Benutzer anzeigen


---

# Verwendete Technologien

| Technologie | Verwendung |
|---|---|
| PHP | Backend und Geschäftslogik |
| SQLite | Speicherung der Daten |
| SQL | Datenbankabfragen |
| HTML5 | Struktur der Webseiten |
| CSS3 | Gestaltung und Layout |
| PDO | Sichere Verbindung zur Datenbank |
| Git | Versionsverwaltung |
| GitHub | Repository und Projektverwaltung |
| Visual Studio Code | Entwicklungsumgebung |
| InfinityFree | Hosting der Anwendung |


---

# Projektstruktur

Die wichtigsten Dateien und Ordner:

```
/
│
├── index.php
├── login.php
├── register.php
├── logout.php
├── product_detail.php
├── cart.php
├── checkout.php
├── dashboard.php
│
├── admin_products.php
├── admin_orders.php
│
├── includes/
│   ├── auth_check.php
│   ├── header.php
│   ├── footer.php
│   └── navbar.php
│
├── css/
│   └── style.css
│
├── images/
│
├── database.sqlite
│
├── setup_db.php
│
└── README.md
```

---

# Datenbank

Das Projekt verwendet eine SQLite-Datenbank.

Die Datenbank wird in folgender Datei gespeichert:

```
database.sqlite
```

Die wichtigsten Tabellen sind:

## users

Speichert alle Benutzer:

- Benutzer-ID
- Benutzername
- E-Mail
- Passwort
- Benutzerrolle


## products

Speichert alle Produkte:

- Produkt-ID
- Name
- Beschreibung
- Preis
- Farbe
- Bildpfad


## cart_items

Speichert Warenkorb-Inhalte:

- Benutzer
- Produkt
- Menge


## orders

Speichert Bestellungen:

- Bestellnummer
- Benutzer
- Lieferadresse
- Datum


## order_items

Speichert die einzelnen Produkte einer Bestellung.

---

# Installation / Setup

## Voraussetzungen

Benötigt werden:

- PHP Server
- SQLite Unterstützung
- Webbrowser


Mögliche Umgebungen:

- XAMPP
- Apache Server
- InfinityFree


---

# Projekt lokal starten

Repository klonen:

```bash
git clone https://github.com/tomicnaima/Abschlussprojekt_2026_API-2_naitom_Board_OnlineShop.git
```

Projektordner in den Webserver-Ordner kopieren.

Beispiel:

```
htdocs/
```

Danach den Server starten.

Projekt im Browser öffnen:

```
http://localhost/Abschlussprojekt_2026_API-2_naitom_Board_OnlineShop
```

---

# Hosting

Das Projekt wurde während der Entwicklung auf InfinityFree getestet.

Da keine lokale Entwicklungsumgebung auf dem Firmenlaptop installiert werden durfte, wurde eine Lösung mit PHP-Hosting und SQLite verwendet.

---

# Testzugänge

## Administrator

Benutzername:

```
admin
```

Passwort:

```
admin123
```


## Customer

Benutzername:

```
customer
```

Passwort:

```
customer123
```


---

# Sicherheit

Folgende Sicherheitsmassnahmen wurden umgesetzt:

- Passwörter werden verschlüsselt gespeichert
- Passwort-Hashing mit PHP Funktionen
- Prepared Statements gegen SQL-Injection
- Zugriffskontrolle durch Sessions
- Prüfung der Benutzerrollen
- Geschützte Admin-Seiten


---

# Testfälle

Die wichtigsten Funktionen wurden getestet:

| Test | Ergebnis |
|---|---|
| Registrierung | Erfolgreich |
| Login | Erfolgreich |
| Logout | Erfolgreich |
| Rollenprüfung | Erfolgreich |
| Produktanzeige | Erfolgreich |
| Warenkorb | Erfolgreich |
| Checkout | Erfolgreich |
| Bestellung speichern | Erfolgreich |
| Produktempfehlungen | Erfolgreich |
| Admin Funktionen | Erfolgreich |


---

# Clean Code

Bei der Entwicklung wurde auf eine saubere Code-Struktur geachtet.

Umgesetzt wurden:

- Aussagekräftige Datei- und Variablennamen
- Wiederverwendbarer Code
- Kommentare bei wichtigen Stellen
- Klare Ordnerstruktur
- Trennung von Funktionen


---

# GitHub Repository

Das vollständige Projekt befindet sich hier:

https://github.com/tomicnaima/Abschlussprojekt_2026_API-2_naitom_Board_OnlineShop


---

# KI-Deklaration

Während der Entwicklung wurde künstliche Intelligenz als Unterstützung verwendet.

Die KI wurde eingesetzt für:

- Analyse von Fehlermeldungen
- Erklärung technischer Konzepte
- Unterstützung bei Problemlösungen
- Verbesserung einzelner Texte
- Formatierung von Text

KI wurde nicht verwendet, um fertige Projektteile ungeprüft zu übernehmen.

# Autorin

Naima Tomic

Individuelle Abschlussarbeit BLJ 2026
