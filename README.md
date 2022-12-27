# rekrutacja_marek_kukulski
Zadanie rekrutacyjne - laravel

docker-compose up --build
docker exec -it app bash
composer i
php artisan migrate

http://localhost:8080/
# gdy pojawi sie problem z laravel.log permission denied
# nalezy nadac odpowiednie uprawnienia w katalogu src poleceniami ponizej()
sudo chown -R $USER:www-data storage
chmod -R 775 storage

#Następnie można wrócić do kontenera app i w nim uruchomić testy:
php artisan test



#API:
# POST http://localhost:8080/api/auth/register - rejestracja Body->form-data
 name => Test1
 email => test1@gmail.com
 password => Test@123

 W odpowiedzi otrzymujemy:
 {
    "status": true,
    "message": "User Created Successfully",
    "token": "6|VNQXA7La5sxPIaKGstNbmONP6GUwpycZsJGk6D7W"
}

# POST http://localhost:8080/api/auth/login - logowanie Body->form-data
 email => test1@gmail.com
 password => Test@123

 W odpowiedzi otrzymumemy:
 {
    "status": true,
    "message": "User Logged In Successfully",
    "token": "7|cOnnY9eltxG73ihhdw1npviCDZjo4H9h5hKHRN01"
}

Token kopijemy i wklejamy do enpointów takich jak store, update, delete w Authorization. ustawiajac wczesniej Barer token.

# POST http://localhost:8080/api/products - dodawanie produktu Body->raw

W headers ustawiamy Accept => application/json

{
   "name":"biurko",
   "description": "opis biurka",
   "prices":[
      {
         "price":5
      },
      {
         "price":10
      }
   ]
}

# GET http://localhost:8080/api/products - lista produktów
Parametry do filtrów:
name (string)
sort_name (asc/desc)
price (int)
description (string)

# GET http://localhost:8080/api/products/{id} - poglad produktu

# PUT http://localhost:8080/api/products/{id} - aktualizacja produktu Body->raw
{
   "name":"biurkoppp",
   "description": "opis biurkappppp",
   "prices":[
      {
        "id": 2,//należy podać id price
        "price":505
      },
      {
        "id": 3,////należy podać id price
        "price":55
      }
   ]
}

# DElETE http://localhost:8080/api/products/9 - usuwanie produktu