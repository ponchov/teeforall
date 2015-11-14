/*

 * German translation

 * @author Dominik Rodler <dominik.rodler@planetinsider.com>

 * @author Christopher Thanisch <christopher.thanisch@gmail.com>

 * @version 2011-01-08

 */

(function($) {

if (elFinder && elFinder.prototype.options && elFinder.prototype.options.i18n)

	elFinder.prototype.options.i18n.de = {

		/* errors */

		'Root directory does not exists'        : 'Root Verzeichnis existiert nicht',

		'Unable to connect to backend'          : 'Verbindung zum Server konnte nicht aufgebaut werden',

		'Access denied'                         : 'Zugriff verweigert',

		'Invalid backend configuration'         : 'Ungültige Serverkonfiguration',

		'Unknown command'                       : 'Unbekannter Befehl',

		'Command not allowed'                   : 'Befehl nicht erlaubt',

		'Invalid parameters'                    : 'Ungültiger Parameter',

		'File not found'                        : 'Datei nicht gefunden',

		'Invalid name'                          : 'Ungültiger Name',

		'File or folder with the same name already exists' : 'Datei oder Verzeichnis mit diesem Namen existiert bereits',

		'Unable to rename file'                 : 'Datei konnte nicht umbenannt werden',

		'Unable to create folder'               : 'Verzeichnis konnte nicht erstellt werden',

		'Unable to create file'                 : 'Datei konnte nicht erstellt werden',

		'No file to upload'                     : 'Es wurde keine Datei ausgewählt',

		'Select at least one file to upload'    : 'Mindestens eine Datei zum Hochladen auswählen',

		'File exceeds the maximum allowed filesize' : 'Die Datei überschreitet die maximal erlaubte Dateigröße',

		'Data exceeds the maximum allowed size' : 'Daten überschreiten die maximal erlaubte Größe',

		'Not allowed file type'                 : 'Dateityp nicht erlaubt',

		'Unable to upload file'                 : 'Datei konnte nicht hochgeladen werden',

		'Unable to upload files'                : 'Dateien konnten nicht hochgeladen werden',

		'Unable to remove file'                 : 'Datei konnte nicht gelöscht werden',

		'Unable to save uploaded file'          : 'Hochgeladene Datei konnte nicht gespeichert werden',

		'Some files was not uploaded'           : 'Einige Dateien wurden nicht hochgeladen',

		'Unable to copy into itself'            : 'Eine Datei kann nicht auf sich selbst kopiert werden',

		'Unable to move files'                  : 'Dateien konnten nicht verschoben werden',

		'Unable to copy files'                  : 'Dateien konnten nicht kopiert werden',

		'Unable to create file copy'            : 'Datei konnte nicht kopiert werden',

		'File is not an image'                  : 'Diese Datei ist kein Bild',

		'Unable to resize image'                : 'Bildgröße konnte nicht verändert werden',

		'Unable to write to file'               : 'Datei konnte nicht gespeichert werden',

		'Unable to create archive'              : 'Archiv konnte nicht erstellt werden',

		'Unable to extract files from archive'  : 'Dateien konnten nicht aus Archiv entpackt werden',

		'Unable to open broken link'            : 'Der Hyperlink ist ungültig',

		'File URL disabled by connector config' : 'Datei-URL in Connector-Konfiguration deaktiviert',

		/* statusbar */

		'items'                                 : 'Objekte',

		'selected items'                        : 'ausgewählte Objekte',

		/* commands/buttons */

		'Back'                                  : 'Zurück',

		'Reload'                                : 'Aktualisieren',

		'Open'                                  : 'Öffnen',

		'Preview with Quick Look'               : 'Vorschau',

		'Select file'                           : 'Datei auswählen',

		'New folder'                            : 'Neues Verzeichnis',

		'New text file'                         : 'Neue Textdatei',

		'Upload files'                          : 'Dateien hochladen',

		'Copy'                                  : 'Kopieren',

		'Cut'                                   : 'Ausschneiden',

		'Paste'                                 : 'Einfügen',

		'Duplicate'                             : 'Duplizieren',

		'Remove'                                : 'Löschen',

		'Rename'                                : 'Umbenennen',

		'Edit text file'                        : 'Textdatei bearbeiten',

		'View as icons'                         : 'Als Symbole anzeigen',

		'View as list'                          : 'Als Liste anzeigen',

		'Resize image'                          : 'Größe des Bildes verändern',

		'Create archive'                        : 'Dateien komprimieren',

		'Uncompress archive'                    : 'Archiv entpacken',

		'Get info'                              : 'Informationen',

		'Help'                                  : 'Hilfe',

		'Dock/undock filemanager window'         : 'Filemanager-Fenster andocken/trennen',

		/* upload/get info dialogs */

		'Maximum allowed files size'            : 'Maximal erlaubte Dateigröße',

		'Add field'                             : 'Feld hinzufügen',

		'File info'                             : 'Dateiinformationen',

		'Folder info'                           : 'Verzeichnisinformationen',

		'Name'                                  : 'Name',

		'Kind'                                  : 'Typ',

		'Size'                                  : 'Größe',

		'Modified'                              : 'Letzte Änderung',

		'Permissions'                           : 'Berechtigungen',

		'Link to'                               : 'Link zu',

		'Dimensions'                            : 'Größe',

		'Confirmation required'                 : 'Bestätigung erforderlich',

		'Are you sure you want to remove files?<br /> This cannot be undone!' : 'Sind Sie sicher, dass Sie diese Dateien löschen wollen?<br />Das Löschen kann nicht rückgängig gemacht werden.',

		/* permissions */

		'read'                                  : 'lesen',

		'write'                                 : 'schreiben',

		'remove'                                : 'entfernen',

		/* dates */

		'Jan'                                   : 'Jan',

		'Feb'                                   : 'Feb',

		'Mar'                                   : 'Mär',

		'Apr'                                   : 'Apr',

		'May'                                   : 'Mai',

		'Jun'                                   : 'Jun',

		'Jul'                                   : 'Jul',

		'Aug'                                   : 'Aug',

		'Sep'                                   : 'Sep',

		'Oct'                                   : 'Okt',

		'Nov'                                   : 'Nov',

		'Dec'                                   : 'Dez',

		'Today'                                 : 'heute',

		'Yesterday'                             : 'gestern',

		/* mimetypes */

		'Unknown'                               : 'unbekannt',

		'Folder'                                : 'Verzeichnis',

		'Alias'                                 : 'Alias',

		'Broken alias'                          : 'defekter Alias',

		'Plain text'                            : 'Textdatei',

		'Postscript document'                   : 'Postscript Dokument',

		'Application'                           : 'Anwendung',

		'Microsoft Office document'             : 'Microsoft Office Dokument',

		'Microsoft Word document'               : 'Microsoft Word Dokument',

		'Microsoft Excel document'              : 'Microsoft Excel Dokument',

		'Microsoft Powerpoint presentation'     : 'Microsoft Powerpoint Dokument',

		'Open Office document'                  : 'Open Office Dokument',

		'Flash application'                     : 'Flash Anwendung',

		'XML document'                          : 'XML Dokument',

		'Bittorrent file'                       : 'Bittorrent Datei',

		'7z archive'                            : '7z Archiv',

		'TAR archive'                           : 'TAR Archiv',

		'GZIP archive'                          : 'GZIP Archiv',

		'BZIP archive'                          : 'BZIP Archiv',

		'ZIP archive'                           : 'ZIP Archiv',

		'RAR archive'                           : 'RAR Archiv',

		'Javascript application'                : 'Javascript Anwendung',

		'PHP source'                            : 'PHP Datei',

		'HTML document'                         : 'HTML Datei',

		'Javascript source'                     : 'Javascript Datei',

		'CSS style sheet'                       : 'CSS Datei',

		'C source'                              : 'C Datei',

		'C++ source'                            : 'C++ Datei',

		'Unix shell script'                     : 'Unix Shell Skript',

		'Python source'                         : 'Python Datei',

		'Java source'                           : 'Java Datei',

		'Ruby source'                           : 'Ruby Datei',

		'Perl script'                           : 'Perl Skript',

		'BMP image'                             : 'BMP Bild',

		'JPEG image'                            : 'JPEG Bild',

		'GIF Image'                             : 'GIF Bild',

		'PNG Image'                             : 'PNG Bild',

		'TIFF image'                            : 'TIFF Bild',

		'TGA image'                             : 'TGA Bild',

		'Adobe Photoshop image'                 : 'Adobe Photoshop Bild',

		'MPEG audio'                            : 'MPEG Audiodatei',

		'MIDI audio'                            : 'MIDI Audiodatei',

		'Ogg Vorbis audio'                      : 'Ogg Vorbis Audiodatei',

		'MP4 audio'                             : 'MP4 Audiodatei',

		'WAV audio'                             : 'WAV Audiodatei',

		'DV video'                              : 'DV Video',

		'MP4 video'                             : 'MP4 Video',

		'MPEG video'                            : 'MPEG Video',

		'AVI video'                             : 'AVI Video',

		'Quicktime video'                       : 'Quicktime Video',

		'WM video'                              : 'WM Video',

		'Flash video'                           : 'Flash Video',

		'Matroska video'                        : 'Matroska Video',

		// 'Shortcuts' : 'Клавиши',

		'Select all files'                      : 'Alle Dateien auswählen',

		'Copy/Cut/Paste files'                  : 'Dateien kopieren/ausschneiden/einfügen',

		'Open selected file/folder'             : 'Ausgewählte Datei/Verzeichnis öffnen',

		'Open/close QuickLook window'           : 'QuickLook Fenter öffnen/schließen',

		'Remove selected files'                 : 'Ausgewählte Dateien löschen',

		'Selected files or current directory info' : 'Informationen über ausgewählte Dateien oder das aktuelle Verzeichnis',

		'Create new directory'                  : 'Neues Verzeichnis erstellen',

		'Open upload files form'                : 'Uploadfenster öffnen',

		'Select previous file'                  : 'Vorherige Datei auswählen',

		'Select next file'                      : 'Nächste Datei auswählen',

		'Return into previous folder'           : 'Zurück zu vorherigem Verzeichnis',

		'Increase/decrease files selection'     : 'Auswahl erweitern/verringern',

		'Authors'                               : 'Autoren',

		'Sponsors'                              : 'Sponsoren',

		'elFinder: Web file manager'            : 'elFinder: Dateimanager für das Web',

		'Version'                               : 'Version',

		'Copyright: Studio 42 LTD'              : 'Copyright: Studio 42 LTD',

		'Donate to support project development' : 'Unterstützen Sie das Projekt mit Ihrer Spende',

		'Javascripts/PHP programming: Dmitry (dio) Levashov, dio@std42.ru' : 'Javascript/PHP Programmierung: Dmitry (dio) Levashov, dio@std42.ru',

		'Python programming, techsupport: Troex Nevelin, troex@fury.scancode.ru' : 'Python Programmierung, technische Unterstützung: Troex Nevelin, troex@fury.scancode.ru',

		'Design: Valentin Razumnih'             : 'Design: Valentin Razumnyh',

		'Spanish localization'                  : 'Deutsche Übersetzung',

		'Icons'                                 : 'Symbole',

		'License: BSD License'                  : 'Lizenz: BSD Lizenz',

		'elFinder documentation'                : 'elFinder Dokumentation',

		'Simple and usefull Content Management System' : 'Einfaches und nützliches Content Management System',

		'Support project development and we will place here info about you' : 'Unterstützen Sie das Projekt und wir erwähnen Sie hier.',

		'Contacts us if you need help integrating elFinder in you products' : 'Kontaktieren Sie uns, wenn Sie Hilfe bei der Integration von elFinder in Ihre produkte benötigen',

		'elFinder support following shortcuts'  : 'elFinder unterstützt die folgenden Shortcuts',

		'helpText'                              : 'elFinder funktioniert ähnlich wie der Dateimanager Ihres Computers. <br />Bearbeiten Sie Dateien mit den Knöpfen der oberen Werkzeugleiste, des Kontextmenüs (Rechtsklick) oder mit Keyboard Shortcuts. Falls ein Symbol missverständlich ist, lassen Sie Ihren Mauscursor über dem Symbol, um einen Hinweis zu sehen. Verschieben Sie Dateien / Verzeichnisse durch Ziehen auf das gewünschten Verzeichnis. Kopieren Sie Dateien durch Verschieben mit gedrückter Shift-Taste.'

		};



})(jQuery);

