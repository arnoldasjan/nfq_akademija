# NFQ Akademijos atrankos užduotis

Projektas buvo atliktas naudojant Symfony framework ir MySQL duombazę (prisijungimai config.php arba .env faile). Buvo parinkta ligoninės sistemos tema.

- Įėjus į pradinį puslapį matoma švieslentė (lightboard).
- Naujas klientas įvedamas skiltyje "New Client".
- Kliento įvedimo formoje panaudota validacija.
- Sėkmingai įvedus klientą jis įrašomas į duomenų bazę ir matomas tiek švieslentėje tiek specialisto puslapyje (Specialist Page).
- Įėjus į specialisto puslapį yra pasirenkamas specialisto tipas ir pagal tai jam parodomi laukiantys pacientai.
- Specialistas aptarnavęs klientą paspaudžia 'Mark As Served' mygtuką ir pažymi, kad klientas buvo aptarnautas.
- Yra galimybė pridėti naujus specialistus (New Specialist) arba peržvelgti jau esamų sąrašą.
- Client Profile puslapyje klientas gali įvesti savo unikalų id ir pasižiūrėti kiek jam prognozuojama laukti (pagal vidutinį jam reikiamo specialisto aptarnavimo laiką).
- Statistics puslapyje galima matyti lentelę, su duomenimis apie tai, kiek skirtingomis dienomis, skirtingi specialistai, vidutiniškai (sekundėmis) užtruko aptarnauti klientus.