# Tag 4 (11.06.2026)

## Was ich heute geschafft habe:

- Login-System gebaut: Ich habe die Datei login.php erstellt. Das Formular prüft, ob die E-Mail in der Datenbank existiert und vergleicht das eingegebene Passwort sicher mit password_verify().

- Sessions eingerichtet: Wenn der Login stimmt, startet eine Session (session_start()). Der Server merkt sich jetzt die ID, den Namen und die Rolle (Kunde oder Admin) des Users, sodass man eingeloggt bleibt.

- Logout-Funktion: Ich habe die logout.php geschrieben. Wenn man darauf klickt, wird die Session komplett gelöscht und man wird abgemeldet.

- Navbar dynamisch gemacht: Ich habe meine navbar.php angepasst. Sie prüft jetzt automatisch die Session-Rolle. Ein Gast sieht "Login" und "Registrieren". Ein Kunde oder Admin sieht seinen Namen, das Dashboard und "Logout".

- Dokumentation erweitert: Ich habe heute auch an meiner Projektdokumentation weitergeschrieben. Ich habe die Meilensteine, die Datenbank-Struktur und das Konzept für die Benutzer-Rollen sauber eingetragen, damit die Dokumentation auf dem aktuellen Stand ist.

## Was gut lief:

- Daslogin.php und das navbar.php hat super geklappt. Die Menüleiste schaltet jetzt um, wenn welcher User sich einloggt. Auch das Schreiben der Dokumentation lief gut, weil ich die Schritte noch frisch im Kopf hatte.

## Schwierigkeiten und Lösungen:

In meiner alten Navbar hatte ich die Variable $_SESSION['role'] genannt, aber im neuen Login-Code hieß sie $_SESSION['user_role']. Deswegen hat die Navbar die Rolle zuerst nicht richtig erkannt und die falschen Links angezeigt.

**Die Lösung:** Ich habe den Code der Navbar kurz überprüft, den Namen auf user_role angepasst und alles glattgezogen. Danach hat der Rollen-Check sofort funktioniert.

## Plan für den nächsten Tag:

Das Login-System ist fertig. Als Nächstes starte ich mit Milestone 2 und kümmere mich darum, dass die Produkte aus der Datenbank auf der Startseite (index.php) angezeigt werden.
