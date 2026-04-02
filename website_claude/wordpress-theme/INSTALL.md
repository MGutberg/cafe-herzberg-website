# Café Herzberg — WordPress Installation

## Schritt 1: WordPress auf IONOS installieren

1. Melde dich bei **IONOS** an → Control Panel öffnen
2. Gehe zu **"WordPress"** oder **"1-Klick-Apps"**
3. Klicke auf **"WordPress installieren"**
4. Bei **"Installationspfad"** eingeben: `/herzberg/`
5. Benutzername, Passwort und E-Mail festlegen → **Installieren**
6. WordPress ist jetzt erreichbar unter: `https://server0001.de/herzberg/wp-admin`

---

## Schritt 2: Theme hochladen

1. WordPress Admin öffnen → **Design → Themes**
2. Klicke auf **"Neu hinzufügen"** → **"Theme hochladen"**
3. Den Ordner `cafe-herzberg/` als **ZIP-Datei** packen
   - Windows: Rechtsklick auf den Ordner → "Senden an" → "ZIP-komprimierter Ordner"
4. ZIP hochladen → **"Jetzt installieren"** → **"Aktivieren"**

---

## Schritt 3: Elementor Pro installieren

1. WordPress Admin → **Plugins → Neu hinzufügen**
2. Suche nach **"Elementor"** → Installieren & Aktivieren
3. Elementor Pro: Die `.zip`-Datei deiner Lizenz hochladen
   - **Plugins → Neu hinzufügen → Plugin hochladen**
4. Elementor Pro aktivieren und Lizenz-Schlüssel eingeben

---

## Schritt 4: Logo hochladen

1. WordPress Admin → **Design → Customizer**
2. **"Website-Identität"** aufklappen
3. Klick auf **"Logo auswählen"** → Logo-Bild hochladen
4. **"Veröffentlichen"** klicken

---

## Schritt 5: Kontaktdaten eintragen

1. WordPress Admin → **Design → Customizer**
2. **"Café Herzberg Einstellungen"** aufklappen
3. **"Kontakt & Adresse"** aufklappen:
   - Adresse: `Eisenacher Str. 3a, 10777 Berlin-Schöneberg`
   - Telefon: `030 91568905`
   - E-Mail: `info@cafe-herzberg.de`
   - Öffnungszeiten eintragen
4. **"Veröffentlichen"** klicken

---

## Schritt 6: Karussell-Bilder einstellen

1. WordPress Admin → **Design → Customizer → Café Herzberg Einstellungen → Hero-Karussell**
2. Für jeden der 3 Slides:
   - Bild aus der Mediathek wählen (oder hochladen)
   - Überschrift, Untertitel und Button-Text eintragen
3. **"Veröffentlichen"** klicken

---

## Schritt 7: Speisekarte befüllen

1. WordPress Admin → **Speisekarte → Kategorien**
2. Kategorien anlegen:
   - `Frühstück`
   - `Mittag & Snacks`
   - `Getränke`
   - `Kuchen & Süßes`
3. WordPress Admin → **Speisekarte → Gericht hinzufügen**
   - Titel: Name des Gerichts
   - Inhalt: Beschreibung
   - Rechts: Preis eintragen, Badge auswählen, Kategorie zuweisen
   - **"Veröffentlichen"**

---

## Schritt 8: Seiten anlegen (Impressum & Datenschutz)

1. WordPress Admin → **Seiten → Neu erstellen**
2. Titel: `Impressum`
3. Rechts unter **"Seitenattribute → Template"** auswählen: **"Impressum"**
4. Fehlende Angaben (Name, USt-IdNr.) im Editor ergänzen
5. **"Veröffentlichen"**
6. Gleicher Ablauf für `Datenschutzerklärung` → Template: **"Datenschutz"**

---

## Schritt 9: Mit Elementor gestalten (optional)

Sobald das Theme aktiviert ist, kann jede Seite mit Elementor bearbeitet werden:
1. Seite öffnen → **"Mit Elementor bearbeiten"** klicken
2. Elemente per Drag & Drop anpassen
3. Für Header/Footer: **Elementor → Theme Builder**

---

## Hilfe

Bei Fragen oder Problemen wende dich an deinen Webentwickler oder schreibe eine Nachricht im Claude Code Chat.
