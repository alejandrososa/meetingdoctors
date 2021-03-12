# Meeting Doctors

En MeetingDoctors nos gusta tener al día los datos de nuestros clientes, así que
importamos diariamente todos datos para poderlos guardar en nuestra BBDD.

Por suerte, cuando hicimos el desarrollo dejamos hecho el servicio :)

https://jsonplaceholder.typicode.com/users

Por otra parte, recientemente se ha cerrado un acuerdo comercial, con lo que una empresa
externa también nos envía un XML con clientes.

Nuestra tarea consiste en hacer una aplicación de consola que al ejecutarse lea el servicio y el archivo, con el objetivo de generar un archivo de salida CSV con el siguiente formato:

| Nombre | Email   | Teléfono | Empresa      |
| ------ | ------- | -------- | ------------ |
| \<name> | \<email> | \<phone>  | \<companyName>|


### Instalación

Clonar este repositorio con `git clone https://github.com/alejandrososa/meetingdoctors.git`

```
cd meetingdoctors && composer install
```

### Ejecutar el comando de consola

No tienes que inicializar la app, solo debes asegurarte que te encuentras en el directorio raíz del proyecto y
ejecutar el siguiente comando:

    cd meetingdoctors
    
    php bin/console app:reports:generate-csv-customers 

El .csv generado con el listado de clientes se encuentra en `config/reports/customers.csv`


## Test with details

Ejecuta los test unitarios y test de integración con el siguiente comando

    php bin/phpunit -c phpunit.xml.dist --testdox

```
PHPUnit 8.5.14 by Sebastian Bergmann and contributors.

Testing Project Test Suite
Generate Csv Customers Handler (MeetingDoctors\Tests\SalesContext\Customer\Application\Command\GenerateCsvCustomersHandler)
 ✔ Throw an exception if httpclient return bad response
 ✔ Throw an exception if xml return is not valid
 ✔ It can create csv

Json Customer Transformer (MeetingDoctors\Tests\SalesContext\Customer\Infrastructure\Transformer\JsonCustomerTransformer)
 ✔ Throw a json exception
 ✔ Must match json with empty·object
 ✔ Must match json with empty·string
 ✔ Must match json with array·with·correct·values
 ✔ Transform data from json

Xml Customer Transformer (MeetingDoctors\Tests\SalesContext\Customer\Infrastructure\Transformer\XmlCustomerTransformer)
 ✔ Throw a xml exception
 ✔ Must match xml with empty·object
 ✔ Must match xml with empty·string
 ✔ Must match xml with array·with·correct·values
 ✔ Transform data from xml

Generate Csv Customers Report Command (MeetingDoctors\Tests\SalesContext\Customer\Ui\Console\GenerateCsvCustomersReportCommand)
 ✔ Validate exists command
 ✔ Execute command

Xml Reader (MeetingDoctors\Tests\SharedContext\Infrastructure\Filesystem\Reader\XmlReader)
 ✔ Must return null if there is an XML file
 ✔ Must return an object if there is an XML file

Csv Writer (MeetingDoctors\Tests\SharedContext\Infrastructure\Filesystem\Writer\CsvWriter)
 ✔ The file must contain a line with the data passed

Transformer Manager (MeetingDoctors\Tests\SharedContext\Infrastructure\Transformer\TransformerManager)
 ✔ Throw an exception if the type is empty
 ✔ Throw an exception if the data is empty
 ✔ Throw an exception if no transformer configured
 ✔ It should return an empty result if not match the type
 ✔ Transform the content

Time: 1.37 seconds, Memory: 10.00 MB

OK (23 tests, 30 assertions)
```

## Test Coverage

Ejecuta los test unitarios y test de integración con el siguiente comando

    php bin/phpunit -c phpunit.xml.dist --coverage-text
