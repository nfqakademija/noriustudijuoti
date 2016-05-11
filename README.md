#Noriu Studijuoti

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/nfqakademija/noriustudijuoti/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/nfqakademija/noriustudijuoti/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/nfqakademija/noriustudijuoti/badges/build.png?b=master)](https://scrutinizer-ci.com/g/nfqakademija/noriustudijuoti/build-status/master)


## FRONTEND paleidimas:
1. Atsidarom terminalą.
2. Einam per terminalą į projekto aplankalą.
3. Paleidžiam webpack komandą. Jeigu komandos neranda (ji nėra instaliuota globaliai) paleidžiam `npm install` komandą ir iš naujo leidžiame webpack komandą.
4. Palaukiame kol komanda bus sėkmingai įvykdyta (viskas turetų būti žalia).
5. Paleidžiame serverį: php app/console server:start
6. (Optional) Jeigu norime, kad nereikėtų atnaujinti kiekvieną kartą webpack bundle'u, tai galime paleisti su `webpack --watch`.
