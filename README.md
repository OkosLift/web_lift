# web_lift
HTML + PHP varázslat

Otthoni használatra php szerver futtatása szükséges.

## használati útmutató

1. magenta gomb fel le nyilakkal - lehet hívni a liftet
2. amikor odaért a lift sárga lesz (nyitva az ajtó) - ilyenkor kell használni a belső zöld gombokat

- alapvetően csukva van az ajtó
- alapból nem lehet megnyomni belül a gombokat
- gombokat a liften belül csak hívás után lehet használni
- a lift képes kezelni egyszerre több lifthívást is

### Következő hibajavítások
- A liftCall() és a ButtonInsideLift() functionok külön mozognak, a terv az hogy egybe tesszük őket, ezzel nagyon sok hibát ki tudunk javítani
