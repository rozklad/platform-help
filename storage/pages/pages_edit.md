## Editace stránky

### Stránka

##### Detaily

+ **Název** - název stránky
+ **Slug** - identifikátor stránky (většinou stejný jako **Url**)
+ **Https** - nadstavba síťového protokolu HTTP (defaultně nastaveno na hodnotu *Ne* není-li na webu implementovaný bezpečnostní certifikát)
+ **Status**
    * *Povoleno* - je-li povoleno, bude se stránka zobrazovat na frontendu
    * *Zakázáno* - je-li zakázáno, nebude se stránka zobrazovat na frontendu
+ **Url** - url adresa, která se zobrazuje v adresní řádce prohlížeče (např. /obchodni-podminky)
+ **Typ úložiště**
    * *Databáze* (defaultní hodnota)
    * *Souborový systém*
+ **Šablona** - doporučení: ponechat defaultně nastavenou šablonu (šablonu nastavuje programátor anebo uživatel po zaškolení v konkrétních případech)
+ **Section** - ponechat defaultně nastavenou hodnotu (section nastavuje programátor)
+ **Obsah** - samotný obsah stránky editovatelný ve WYSIWYG editoru


### Oprávnění

#### Kontrola přístupu

+ **Viditelnost**
    * *Vždy zobrazená* - zobrazení stránky všem uživatelům na frontendu
    * *Pouze přihlášeným* - zobrazení stránky pouze přihlášeným uživatelům na frontendu
    * *Pouze administrátorům* - zobrazení stránky pouze administrátorům na frontendu

+ **Role** - v případě existence Rolí lze vybírat jednotlivé role (uživatele s rolí), kteří ke stránce mohou přistupovat na frontendu.


### Navigace

##### Navigace

+ **Menu** - výběr navigace, do kteřé se má přiřadit stránka. Stránky do navigace lze přiřazovat z tohoto nastavení i z modulu Navigace.


### Štítky

#### Štítky

+ **Štítky** - výběr anebo vytvoření štítku. Existující štítek stačí vybrat. Nový štítek se vytvoří po napsání jeho názvu do pole a kliknutím na tlačítko **Add**. Zobrazení štítků na frontendu a práce s nimi (např. filtrace) vychází ze šablony a funkcionalit vyplývajících ze specifikace a dalších požadavků.


### Atributy

##### Atributy

+ **Meta Title** - titulek stránky pro vyhledávače
+ **Meta Description** - popisek stránky pro vyhledávače

Nový atribut lze vytvořit kliknutím na tlačítko **Vytvořit**.