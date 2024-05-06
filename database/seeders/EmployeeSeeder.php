<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\ApprehendingOfficer; // Assuming your model is officerd Employee

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $calaxx = [
            "Aladad, Lorelie G.",
            "Angcao, Klinth A.",
            "Bautista, Celso Jr. A.",
            "Antonio, Jayson E.",
            "Brazil, Paul M.",
            "Bueno, Jetty F.",
            "Calitis, Cian Dominik C.",
            "Candado, Sabiniano Jr. T.",
            "Casugay, Chelly M.",
            "Chavez, John Dominic DC.",
            "Cometa, Dwight Douglas M.",
            "Contreras, Christian C.",
            "Dacoco, Dan Jacob S.",
            "De Guzman, Gerick L.",
            "Gonzalez, Jobert G.",
            "Geron, Oliver V.",
            "Hernandez, Simon Gabriel S.",
            "Jamolin, Domar C.",
            "Javinar, Jeff Rod B.",
            "Jangao, Randy T.",
            "Listerio, Jefferson J.",
            "Luna, Josefino Jr. V.",
            "Milla, Noel B.",
            "Namoco, Nathaniel A.",
            "Pangco, Christian Cedrick C.",
            "Rojas, Sarah Mae S.",
            "Role, Gerry R.",
            "Sicapore, Rodel M.",
            "Tulfo, Mark Anthony M.",
        ];
        foreach ($calaxx as $calax) {
            $department = "CALAX";
            ApprehendingOfficer::create([
                
                'officer' => $calax,
                'department' => $department,
            ]);
        }
        $dommdax = [
            "Acosta, Edwin M.",
            "Benalla, Roberto S.",
            "Collera, Eriberto A.",
            "Condat, Rosario T.",
            "Gonzales, Lilet L.",
            "Halcon, Dexter T.",
            "Padilla, Dennis M.",
            "Reginaldo, Rey C.",
            "Tomaneng, Marisol V.",
        ];
        foreach ($dommdax as $dommda) {
            
            $department = "DO MMDA";
            ApprehendingOfficer::create([
                'officer' => $dommda,
                'department' => $department,
            ]);
        }
        $TPLEXX = [
            "Opsima, Nonito Jr Constantino",
            "Limiac, Neil Clark Mallari",
            "Dizon, Laverne Bernardo",
            "Corbillon, Dennis Dicipulo",
            "Pagcu, Jowell Dizon",
            "Tabora, Romulo Jr. Gutierrez",
            "Zamora, Adrian Siron",
            "Figueroa, Jing Austria",
            "Villamayor, Jordan Dizon",
            "Cabañero, Loyd Calpito",
            "Hacla, Arman Peralta",
            "Capuno Jose Rosario Supan",
            "Reyes, Apple David",
            "Valentino, Jeffrey Capili",
            "Dalluay, Jenifer Tapucol",
            "Dela Cruz, Jameson Buhay",
            "Saborboro, Harvey Vinuya",
            "Ancheta, Randy Matamis",
            "Arce, Bonna Karla Aquino",
            "Arzaga, Hermes Al Del Rosario",
            "Baladhay, Gervic Gora Sicat",
            "Biala, Lan Albert Briones",
            "Bognot, Tovie Renz Rebucca",
            "Bucad, James Paul Pacete",
            "Cabarles, Narciso Jr. Menoncia",
            "Cachuela, Jaycee Cappal",
            "Capili Nikko Cerezo",
            "Chico, Leonilo Cubas",
            "Doctora, Lionel Sosa",
            "Domingo, Lerrie Arbitrario",
            "Santos, Jerome N.",
            "Aningat, Benjamin E.",
            "Bulaon, Shaira Pauline P.",
            "Concepcion, Gilbert G.",
            "Cuaresma, Rebecca G.",
            "Fernando, Jhon Paul T.",
            "Lopez, Mark Ryan",
            "Dumandan, Jerome David",
            "Dumantay, Eduardo Valix",
            "Estabillo, Rawlence",
            "Facun, John Henry Ancheta",
            "Flaminiano, Philippe Laquian",
            "Galvan, Angelito Antalan",
            "Gan, John Michael Casuga",
            "Garcia, Eddie Fabros",
            "Gomez, Mark Paul Antolin",
            "Gonzales, Ryan Ronnie",
            "Inalvez, Adelson Espinosa",
            "Justo, Liewel Jude Patiag",
            "Labiano, Mark Siquig",
            "Licudo, Franklin Martir",
            "Macalolooy, Edrei",
            "Mancha, Jonard Canata",
            "Mariano, Reynold Requa",
            "Masanque Rommel Jay",
            "Navarro, Randy Benjamin",
            "Nunag, Joren Bularan",
            "Ortiz, Jehu Costales",
            "Ortiz, Frederick Albert",
            "Panlilio, Jhefrank Hipolito",
            "Pascual, Jaymart Garcia",
            "Pineda, John Ronald Romero",
            "Sumang, Jens Peter Felipe",
            "Tubay, Jemar Espinosa",
            "Ugaddan, Ronnie",
            "Umayam, Christopher",
            "Valdez, Walter Capistrano",
            "Pascua, Venus V.",
            "Perez, Jian Carlo A.",
            "Tabugan, Rafael M.",
            "Taoatao, Marchele Mae M.",
            "Ong, Armel R.",
            "Patangui, Patrick O.",
        ];
        foreach ($TPLEXX as $TPLEX) {
            
            $department = "TPLEX";
            ApprehendingOfficer::create([
                'officer' => $TPLEX,
                'department' => $department,
            ]);
        }
        $LES = [
            "Estrellado, Eric N.",
            "Agurin, Melicio Jr R",
        ];
        foreach ($LES as $FED) {
            $department = "DO-LES-FED";

            ApprehendingOfficer::create([
                'officer' => $FED,
                'department' => $department,
            ]);
        }
        $donlexx = [
            "Pasco, Mark Anthony M.",
            
        ];
        foreach ($donlexx as $donlex) {
            $department = "DO-NLEX";

            ApprehendingOfficer::create([
                'officer' => $donlex,
                'department' => $department,
            ]);
        }
        $STARTOLLX = [
            "Abjelina, Danilo J.",
            "Moster, Francisco T.",
        ];
        foreach ($STARTOLLX as $STARTOLL) {
            $department = "DO-STARTOLL";

            ApprehendingOfficer::create([
                'officer' => $STARTOLL,
                'department' => $department,
            ]);
        }
        $mcxx = [
            "Bandolin, Jojo M.",
            "Castillo, Baddie T.",
            "Gervacio, Abraham Blas C.",
            "Lorica, Felipe P.",
            "Andico, Andre T.",
            "Reblando, Raul R.",
            "Nuñez, Noel S.",
            "Jabajab, Michael C.",
        ];
        foreach ($mcxx as $mcx) {
            $department = "MCX";
            ApprehendingOfficer::create([
                'officer' => $mcx,
                'department' => $department,
            ]);
        }
        $nlexx = [
            "Abraham, Rommel I.", "Ajose, Jordan Paul L.", "Alano, Joji O.", "Anesco, Aldrin O.", "Ang, Ranny P.", "Angeles, James Amiel A.", "Angeles, Jerwin O.", "Angeles, Ronan Jae D", "Aquino, Ismael S.", "Arcilla, Jhan Carl", "Arellano, Erlie M.", "Arellano, Rowland A.", "Avendaño, Jeremie J.", "Avila, Reymond M.", "Ayao, Edmer D.", "Azarcon, Jeffrey T.", "Baclayo, Loreto Jr. S.", "Bacolor, Aristeo M.", "Bada, Carl Patrick A.", "Bahana, Mark Archie B.", "Balaoing, Claessie C.", "Balisi, Rinal M.", "Bantigue, Ramil D.", "Barata, Noli R.", "Barret, Genesis T.", "Batoon, Christian C", "Batungbakal, Erish L.", "Bautista, Kenneth B.", "Berboso, Albert M.", "Bernal, Zxyrrah Grace", "Bernardino, Mark Bryan C.", "Beroy, Ariel L.", "Bimmao, Lorenzo Jr. T.", "Bituin, Jaybee T.", "Blay, Madel P.", "Bondoc, Ariel N.", "Bundalian, Ramuel R.", "Bungalon, Ireneo R.", "Bustamante, Ronie D.", "Cabildo. Allan C.", "Cadiz, Jay R.", "Calayag, Mac James C.", "Caliuag, Michael G.", "Calunod, Edgar D", "Camua, Marvin R.", "Canlas, Francis S.", "Canlas, Jolly Ken S.", "Capalad, Mervin N.", "Capitly, Tyrone L.", "Casabuena, Gilbert Dc.", "Castañeda, Emmanuel C.", "Castillo, Emiliano B. Jr.", "Castro, Carlo II F.", "Castro, Mark Lorenz H.", "Castro, Mitchelle D.", "Castro, Noel S.", "Catangal. Kenneth M.", "Catolico, Christopher P.", "Celestino, Warren E.", "Cortez, Marvin T.", "Covacha, Junfeb B.", "Cruz, Eric V.", "Cruz, Jayvin R.", "Cruz, John Victor D.", "Cruz, Mariejoberolyn", "Cruz, Nathaniel R.", "Datu, Marlon P.", "David, Adrian Paul D.", "David, Emmanuel L.", "David, Jonie L.", "David, Michael G.", "David, Nicofort C.", "David, Nicolai C.", "Davo, Fernando B.", "Dayao, Sydrick Y.", "Dayrit, Alexander L.", "Dayrit, John Paul G.", "De Castro, Jayvee B.", "De Celis, Glenn Arnel", "De Guzman, Ryan P.", "De Jesus, John Matthew R.", "De Jesus, Kristoffer Ryan B.", "De Vera, Rassel Marie J.", "Deang, Regiemer John M.", "Del Mundo, Catherine P.", "Del Rosario Edwin C", "Dela Cruz, Gary S.", "Dela Cruz, Jeffrey D.", "Dela Cruz, Martinoel C.", "Dela Cruz, Noel Joseph P.", "Dela Cruz, Phillip T.", "Dela Cruz, Ronaldo S.", "Dela Pena, Leonides G. Jr.", "Dela Rosa Roger I.", "Delante, Carl John C.", "Delos Santos, John Lorenze", "Diaz, Aristotle R.", "Diaz, Edgardo G.", "Divinoto, Salvador L.", "Doctolero, Marlon V.", "Dollete, Allan", "Doton, Jhon Val M", "Dulalia, Freddie D.", "Duran, Elibert N.", "Echavez, Leonard Cedrick G.", "Espartero, Herbert V.", "Estrella, Joel F.", "Facun, Adonis E.", "Fajardo, Floyd E.", "Fajardo Irish D.", "Felipe, Richardson T.", "Fernandez, Daryl Dwight V.", "Francia, Franklin G.", "Gabayan, Renato", "Gabriel, Elmerson C.", "Galang, Jose Christopher", "Galang, Mardy S.", "Gamba, Aldrin SJ.", "Gante, John Louie R.", "Jarcia, Bryan P", "Garcia, John Carlo C.", "Garcia, Wally B.", "Garonita, Neal lan M", "Gatdula, Alex C.", "Gaudario, Angelo J.", "Gigante, Ericson D.", "Giron, Felix F.", "Gonzales, Patrick M", "Guadalupe, Virgilio B.", "Gueco, Lourel M.", "Gueco, Randy D.", "Gueta, Alex R.", "Guevarra, John Philip D.", "Guevarra, Jon Axle C.", "Guillermo, Roel C.", "Gurion, Mark Joseph S.", "Gutierrez, Andrea C.", "Halili, Gieny Roger M.", "Hipolito, Jeric D.", "Ibardolaza, Dennis I.", "Ignacio, Christopher M.", "Ignacio. John Ryan", "Japsay, Mark Joel S.", "Jaring, Rafael I.", "Jauco, John William M.", "Jimenez, Anna Patricia H", "Labutong, Dan Carlo", "Lacap, Mary Grace Jessa Y.", "Lacson, Meldwyn Maike", "Lagman, Mark Anthony A.", "Lagula, Patrick S.", "Lapira, Jim L.", "Leano, Abdul Guillermo Q.", "Leonidas, Ronaldo G.", "Llarves, Vince Nichole A.", "Lubo, Ralph Justin S.", "Lusung, Maria Theresa T.", "Mabunga, Rodel C.", "Macapagal, Reggie G.", "Magdaraog, Paul C.", "Mallari, Santa M.", "Mamawan, Richard A.", "Manalang, Angel Jr D.", "Manalang, Michael S.", "Manalaysay, Wally G.", "Manalili, John Paul C.", "Manalili. Nikkolo N.", "Manguera, Eldon M.", "Manongdo, Mark Patrick B", "Manuel, Christian T.", "Mariano, Gian Joseph S.", "Martinez, Brylle G.", "Masajo, Joseph K.", "Mauricio, Adrian G.", "Medrano, Jeffrey M.", "Mendoza, Carol Jane B.", "Mendoza, Claire Nicole A.", "Mendoza, Dennis S.", "Mendoza, Levy T.", "Mendoza, Mark Gabriel A.", "Mendoza, Michael R.", "Mendoza, Prince Briel", "Mercado, Dionisio A.", "Mercado, Jericho M.", "Miranda, Jefferson M.", "Miranda, Margarita P.", "Morada, Armiel J.", "Musngi, Jay L.", "Nacino, Maria Margie G.", "Nanquil, Don M.", "Narciso, Paul John Ross L.", "Navarro, Marcelo II A.", "Nicolas, Renz Harvey T.", "Noceda, Geronimo Jr A.", "Nogal, Josue Jr. D.", "Nogoy, Sherwin C.", "Noquiz, Joven H.", "Ocampo, Michael G.", "Orante, Ronald Allan D.", "Origen, James B.", "Orpiano, Ishiko M.", "Pabalan, Jerome P.", "Paglinawan, Nelson D.", "Pangilinan, Alvin M.", "Pangilinan, lan M.", "Pangilinan, Juan Paolo M.", "Paruli, Ricky M.", "Pascual, John Patrick D.", "Pascual, Jonathan L.", "Pasion, Mel Vin C.", "Payabyab, Krypton M.", "Payabyab, Rowel P.", "Peñaflor Jason L. Jr", "Peralta, Danica Louie M.", "Perez. Merwin G.", "Petilo, Michael B.", "Piga, Porferio Jr. S.", "Pili, Kristofer P.", "Pillado, Rhea Jennifer P.", "Pingol, Roderico M.", "Piquero, Haji C.", "Policarpio, Patrick B.", "Preligera, Domingo C. Jr.", "Punzalan, Onofre Jr. S.", "Quiambao, Russel John Y.", "Rabosa, Christopher P.", "Ramirez, Francis Lloyd P.", "Ramos, Jose Dennis N.", "Ramos, Rex M.", "Ratilla, Jover D.", "Raymundo, Renz Angelo L.", "Razon, Jasper L.", "Redondo. John Louie D.", "Regala, Dennis A.", "Reyes, Antonio Igmidio III T.", "Reyes, John Edgard M", "Rivera, Ryan", "Rodriguez, Joseph J.", "Rontal, Ricardo M.", "Rosal, Julius Anthony S.", "Roxas, John Emmanuel V.", "Roxas, Jonry Emanuelle S.", "Roxas, Winniefredo", "Sabado, Chester Daniel T.", "Sabado, Kathleen G.", "Saliganan, Joan C.", "Salire Ernesto", "Salonga, Jackielyn R.", "Saludo, Jester D", "Salvacion, Orlando Jr. O.", "Samaniego, Jay L.", "San Pedro, Albert B.", "San Pedro, Jolly B.", "San Pedro, Reymarkh S.", "Sanchez, Allan Mark D.", "Sanchez, Benigno Jr. I.", "Sanchez, Elvin Bryan O.", "Santiago, John Kenneth Ds", "Santiago, Paul Rhyan B.", "Santiago, Raymart L", "Santos Jr. Albert Kenneth S.", "Santos Reuter Kenneth N.", "Santos, Enrico B.", "Santos, Ma. Rhea Rose N.", "Santos, Mark Chester A.", "Santos, Mary Joy M.", "Santos, Paolo B", "Santos, Ronaldo M.", "Santos, Wilson S.", "Santos, Wilson V.", "Segundo, Eric G.", "Sendin, Jasper L.", "Sevilla, Rodenie S. G.", "Siapengco, Roel J.", "Sibal, Rhely P.", "Simbulan, Bernan M.", "Solis, Jaybez B.", "Solis, Jaye Brylle V.", "Sugue, Allan C.", "Sumadsad, Christopher A.", "Tadeo, Rover John C.", "Talosig, Chriz Angeli S.", "Talosig, Mc Lawrence S.", "Tantengco, Warren S.", "Tiquia, Lawrence Aaron L.", "Toledo, Walter L.", "Tolentino, Daniel I.", "Tolentino, Joseph G.", "Tomas, Apl Ryan R.", "Torres, Genesis R.", "Tuazon, Richard C.", "Urbiztondo, Roden O.", "Uy, Liezel C.", "Valencia, Marie Joy C.", "Valentin, Alexis V.", "Valerio, Ruben M.", "Valido, Francis Romulo R. Jr.", "Vergara, Jon Michael N.", "Victoria, Warren L.", "Villareal, George A.", "Villegas, Julius T.", "Vitug, Teresito B.", "Wong, Lee Jacob", "Yco, Ernell S.", "Yusi, Ritche Louie B.", "Yutuc, Filemon lii N.", "Zabat, Emerson R."

        ];
        foreach ($nlexx as $nlex) {
            $department = "NLEX";
            ApprehendingOfficer::create([
                'officer' => $nlex,
                'department' => $department,
            ]);
        }
        $pcgx = [
            "CG PO3 Abundol, Julius Gibran",
            "CG PO3 Austria, Alex",
            "CG SN1 Britania, Ernesto",
            "CG SN1 Callangan, John Paul",
            "CG SN1 Carale, Rodnell",
            "CG PO3 Cueno, Reden",
            "CG SN1 Dela Cruz, Reymart",
            "CG SN1 Dambong, Alfarhan",
            "CG PO3 Deguilmo, Peter Jinel",
            "CG SN1 Dinglasan, Keneth",
            "CG SN1 Flora, Christian",
            "CG SN1 Glariana, Condrado",
            "CG SN2 Hassan, Fahar",
            "CG SN1 Jambalos, Raymond",
            "CG SN1 Lazaro, Richard",
            "CG SN1 Machon, Jonas",
            "CG SN1 Macula, Marvence",
            "CG SN1 Magpuyao, Reymar",
            "CG SN1 Mauricio, Juanito Jr.",
            "CG SN1 Mazo, Jaymark",
            "CG SN1 Mirabete, Jobel",
            "CG SN1 Montemayor, Jayson",
            "CG SN1 Naranjoso, Kennedy",
            "CG SN1 Nur, Hussein",
            "CG SN1 Padua, Lambert",
            "CG PO3 Panganiban, Jhon Leo",
            "CG PO3 Salapuddin, Isaac",
            "CG SN1 Tilaon, Justine",
            "CG SN1 Valenzuela, Dante",
            "CG SN1 Villamor, Virgilio",
            "CG SN1 Zapanta, John Michael"
        ];
        foreach ($pcgx as $pcg) {
            $department = "PCG";
            ApprehendingOfficer::create([
                'officer' => $pcg,
                'department' => $department,
            ]);
        }
        $startollxz = [
            "Aceron, John Paul M.",
            "Aclan, Ferdinand M.",
            "Atienza, Harley C.",
            "Baldivia, Roldan",
            "Banta, Vincent E.",
            "Bautista, Elmer S.",
            "Bodo, Wilson P.",
            "Braza, Michael Gerard L.",
            "Buela, Nemesio U.",
            "Bunsol, Henry M.",
            "Burgos, Adrian V.",
            "Cabatay, Jaypee Z.",
            "Cantos, Jommel L.",
            "Dimayuga, Edmundo M.",
            "Elis, Gabriel Jr. C.",
            "Gallo, John John Z.",
            "Gonzales, Nilo",
            "Hernandez, Gerber",
            "Landicho, Marvin Ross C.",
            "Lambit, Patrick John P.",
            "Latay, Francisco C. ***Nothing",
            "Leyba, Erickson M.",
            "Lina, Arwen R.",
            "Llanes, Marlon",
            "Mabiling, Teodor M.",
            "Magpantay, Leonardo D.",
            "Maldonado, Joseph T.",
            "Mendoza, Marvin O.",
            "Mendoza, Dervin Jesus G.",
            "Miguel, Jourdan L.",
            "Olan, Jaime D.",
            "Parra, Jerome A.",
            "Pastrana, Arnold G.",
            "Punzalan, Ella S.",
            "Ramos, Jose F.",
            "Tiemsem, Marvin T.",
            "Toledo, Ronald M.",
            "Torres, Genver M.",
            "Viceral, Angelo C.",
            "Villanueva, Reynaldo",
            "Villasanta, Ruel C.",
            "Vivas, Ernesto Jr. B."
        ];
        foreach ($startollxz as $startollx) {
            $department = "STARTOLL";
            ApprehendingOfficer::create([
                'officer' => $startollx,
                'department' => $department,
            ]);
        }
        $peatcx = [
            "Bataguis, Aladin D.",
            "Callano, Ricardo Jr.",
            "Garcia, Michael Brian",
            "Lim, Benjamin Joseph M.",
            "Mahayag, Philip Ace A."
        ];
        foreach ($peatcx as $peatc) {
            $department = "PEATC";
            ApprehendingOfficer::create([
                'officer' => $peatc,
                'department' => $department,
            ]);
        }
        $saictx = [
            "Alejandro, Sonny",
            "Almoete, Michael Rey",
            "Barnachea, Sarah Jane",
            "Ballesteros, Christian James",
            "Baraquiel, Sonny Boy",
            "Bermudez, Jean Claudio",
            "Bersamina, Yin Rei",
            "Bodoso, John Darwin",
            "Cabanban, Hervin",
            "Cezar, Mark Joseph",
            "Chico, Jhed Gabriel",
            "Conde, Edgardo II",
            "Dagdag, Juanito Jr",
            "Dela Cruz, Eric",
            "Dela Torre, Rayson",
            "Dumallay, Galang",
            "Dumallay, Gary Leo",
            "Frilles, Steve",
            "Garcia, Balthazar Francis",
            "Guerrero, Bonifacio",
            "Limson, Gino",
            "Naral, Bien Joseph",
            "Manejo, Manuel Jr.",
            "Martin, Jonathan",
            "Paddayuman, Robin",
            "Padilla, Nestor",
            "Pejer, Ron Jared",
            "Quebec, Ricardo",
            "Salen, Jennifer",
            "San Diego, Paul Ryan",
            "Santos, Frederick",
            "Soliven, Perfecto Jr.",
            "Torres, Danilo Jr.",
            "Turla, Roldan"
        ];
        foreach ($saictx as $saict) {
            $department = "SAICT";
            ApprehendingOfficer::create([
                'officer' => $saict,
                'department' => $department,
            ]);
        }
        $skywayx = [
            "Acheta, Ramil S.",
            "Agleron, Pedro A.",
            "Aguila, Michelle O.",
            "Anday, Marion L.",
            "Axalan, Edwin G.",
            "Baldeo, Sherly G.",
            "Barquilla, Jose Marie L.",
            "Basa, Allan Andrew R.",
            "Basas, Rodrigo V.",
            "Caberio, Winston C.",
            "Cagande, Aulereus Leonard B.",
            "Calugay, Rene T.",
            "Oblena, Ambeceder D.",
            "Oliveros, Dante M.",
            "Ortiaga, Efren S.",
            "Pagaduan, Whinmar A.",
            "Pagarao, Mark Adrian S.",
            "Palisoc, Jessie R.",
            "Palmones, Elpidio Jr H",
            "Penasbo, Reynaldo B.",
            "Pilaspilas, Randy P.",
            "Puray, Randy D.",
            "Ramirez, Albert C.",
            "Reponte, Jon Rupert D.",
            "Reyes, Marcelo B.",
            "Rollan, Anastacio R.",
            "Cayton, Cesar S.",
            "Chan, Richard D.",
            "Cuayson, Jeff Randell A.",
            "Ruz, Emilio F.",
            "De Roxas, Kenneth Xamier E.",
            "Deang, Carlos A.",
            "Dela Cruz, Jhonrick A.",
            "Sevilla, Raymond L.",
            "Sison, John Mark V.",
            "Delos Santos, Ronie B.",
            "Dilla, Vermeo Marcky Son L.",
            "Dulnuan, Raymond dexter T. Jr",
            "Fermano, Geneto L.",
            "Furio, Felino F.",
            "Galang, Rufino B",
            "Gomez Ruther Van S.",
            "Gonzales, Roberto F.",
            "Tenedero, Jose C.",
            "Torres, Jim Brian G.",
            "Acbo, Alexander F.",
            "Agripa, Jheypersun Arquines, Wilson L.",
            "Guiyab, Arsenio A.",
            "Balla, Ryan P.",
            "Bañaga, Robert B.",
            "Bondad, Joel P.",
            "Labagnoy, Leonardo H. Jr",
            "Libo-on, Ranmar B.",
            "Lim, Roderick U.",
            "Cagunot, Joan T.",
            "Callangan Teburcio jr H.",
            "Lirio, Efren B. Jr.",
            "Magabo, Reymart M",
            "Dagui, Rexenor M.",
            "Daguman, Richard M.",
            "Marasigan Dennis G.",
            "Mendoza, Catalino S.",
            "Ojeda, Rolando Jr T.",
            "Osabel, Esteban Jr B.",
            "Padulle, Pablito M.",
            "Pasigua, Jerous S.",
            "Paz, Sandie C.",
            "Pilac, Regie B.",
            "Piol, Joven d.",
            "Plaza, Jenny G.",
            "Prades, Edison S.",
            "Sambo, Dennis C.",
            "Saporno, Romulo Jr G.",
            "Sayo, Jose S.",
            "Tulabing, Richard C.",
            "Utap. Ali A.",
            "Vicente, Jaylord M.",
            "Untalan, Angelito M.",
            "Valera, Byron R.",
            "Nabo, Christian C.",
            "Tamayao. Rodel C.",
            "Chan, Kim G.",
            "Abucay, Edson Francis B.",
            "Alto, Pelvie John A.",
            "Alvarez, Mark Anthony P.",
            "Amores, John Jerick F.",
            "Andaya, Raun F.",
            "Antonio, Joshua P.",
            "Bagsain, Jerelle A.",
            "Balagosa, Erneva O.",
            "Bautista, Venus Ryen S.",
            "Bayer, Roberto Jr A.",
            "Buñing, Nicole S.",
            "Cabanilla, Rowena G.",
            "Cervera, Tyrone D.",
            "Corocoto, Enrique B.",
            "Cortez, Allan Paul A.",
            "Cose, Bryan D.",
            "Del Barrio, Ricky D.",
            "Dolor, Emmel V.",
            "Elep, Ranniel C.",
            "Ergina, Carlo A.",
            "Funtanilla, Dominador D.",
            "Garcia, Romeo Jr L.",
            "Genon, Ricky A.",
            "Gervacio, Emelyn S.",
            "Hernaez, Felix Jr C.",
            "Hitosis, Richard E.",
            "Igana, Aileen D.",
            "Junio, Edward B.",
            "Lajara, Michico D.",
            "Magana, Joe S.",
            "Mapalad, Michael S.",
            "Montalbo, Jonelor G.",
            "Mortel, Leonard B.",
            "Naje, Richard James W.",
            "Nardo, Bryan D.",
            "Olores, Neptalie A.",
            "Ones, Eduvegio Jr A.",
            "Orjaleza, Randolf V.",
            "Pagulong, Nelson P.",
            "Parcon, Erlie T.",
            "Pili, Florida D.",
            "Poniente, Marco R.",
            "Ramos, Edgar Jr M.",
            "Santos, Analyn C.",
            "Sebastian, Mc Davis R.",
            "Solis, Jan Ryan V.",
            "Tamayo, Rico T.",
            "Gula, Rowena B.",
            "Veloria, Clifford Brian B.",
            "Vierneza, Jomine D."
        ];
        foreach ($skywayx as $skyway) {
            $department = "SKYWAY";
            ApprehendingOfficer::create([
                'officer' => $skyway,
                'department' => $department,
            ]);
        }
        $slexx = [
            "Aala, Elaine Jane P.",
            "Abala, Meliton P.",
            "Abon, Timoteo B",
            "Acedilla, Gryvic T",
            "Alcantara, Genell P",
            "Alforja, Marvic R",
            "Arciaga, Allan C",
            "Asañas, Manuel F Jr",
            "Aujero, Jettz O",
            "Baculanlan, Randulf E",
            "Badilla, Roel N",
            "Balingit, Ulysses E",
            "Bautista, Allan Christian S",
            "Benardez, Antonio S",
            "Bulusan, Jomar A",
            "Cabase, Jonthan D:",
            "Carandang, Reymart H",
            "Casaus, Maximiliano P",
            "Comia, Mario C",
            "Contreras, Charles Kevin M",
            "Robles, Cesar M",
            "Cruz, Eric DC",
            "Daria, Arjil B",
            "De Luna Ariel M",
            "Dela Cruz Joshua G",
            "Duquilla, Bryan A",
            "Elegino, Elgin M",
            "Gangan, Arjay D.",
            "Gaño. Romeo B.",
            "Inhayes, Romelito A.",
            "Jazmin, Noel P.",
            "Jimenez, Rondal Vincent",
            "Jocson, Meldrex L.",
            "Lagando, Randy L.",
            "Lebico, Floro C Jr",
            "Maglinte, Roderick V",
            "Lizardo, Loureno Dc",
            "Lugo, Erwin P",
            "Macalinga, Albert C",
            "Malvas, Arnold M",
            "Manarin, Marcelo T",
            "Manguiat, Ernesto C Jr",
            "Mataac, Gilbert F",
            "Mayuga, Brenn Jayson P",
            "Medel, Christian Jake G",
            "Mejia, Arnel A",
            "Mendoza, Deniesyl G B",
            "Mendoza, Marvin O",
            "Miraflor, Joevil E",
            "Moldez, Fervin V",
            "Muleta, Eric R",
            "Mundin, Lowie J",
            "Natanauan, Elmer A",
            "Nora, Michael J",
            "Espejo Ehrnest Vernier D",
            "Obrero, Garry S",
            "Espinosa, Eraño P",
            "Evagelista, Mario T",
            "Fajarda, Erick B",
            "Flores, Aaron V",
            "Fresnedi, Jayson M",
            "Galdones, Neil S",
            "Oliva, Howell S",
            "Oña, Nixon D",
            "Pajanustan, Diosdado T",
            "Pepa, Joel L",
            "Perez, Leonardo H",
            "Perez, Romano Joseph M",
            "Piong, Renilo M",
            "Puddao, Adolfo P.",
            "Raymundo, Ronaldo P",
            "Reuteras, Wally R",
            "Rico, Jay-R M",
            "Romantico, Amando T",
            "Rufin, Rodrigo J Jr",
            "Samonte, Christian Lan G",
            "Sandrino, Paulo S",
            "Sullano, Jerry M",
            "Tabucao, Francis Kenneth G",
            "Thomas, Ulysses D",
            "Tugas, Lan C",
            "Vallecera, Andres T.",
            "Victoriano, Dave R",
            "Villegas, Jerome C",
            "Yarde, Apolonio S",
            "Dela Cruz, Ruel L",
            "Arcilla, Leandro A.",
            "Balba, Mark Gil A.",
            "Barredo, Jonathan B.",
            "Besueno, Alexis F.",
            "Cabagbag, Jayson G.",
            "Castillo, Willard B.",
            "Concepcion, Lloyd Nicole S.",
            "Cornelio, Zandy B.",
            "Flores, Rodjer D.",
            "Macanip, Edison M.",
            "Maitim, Michael V.",
            "Malba, Benedick Jerome O.",
            "Malinao, Jefferson F.",
            "Pereyra, Joshua G.",
            "Sore, Krystel Mae S.",
            "Villanueva, Ervin A.",
            "Velayo, Ronlo F.",
            "Zuñiga, Ace Anthony R"
        ];
        foreach ($slexx as $slex) {
            $department = "SLEX";
            ApprehendingOfficer::create([
                'officer' => $slex,
                'department' => $department,
            ]);
        }
    }
}
