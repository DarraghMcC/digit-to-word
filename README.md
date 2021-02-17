# Dollar to Words
Application, which converts dollar (and cents) digit representation to words.

This is a rest application build using Laravel PHP. 

Some input/putput examples:

| Input | Output                             |
| ----- | ---------------------------------- |
| 0     | "Zero Dollars"                     |
| 0.12  | "Twelve Cents"                     |
| 10.55 | "Ten Dollars and Fifty Five Cents" |
| 120   | "One Hundred and Twenty Dollars"   |

***

## Endpoint

GET `/api/convert/{dollarDigits}`
 
Valid Request Response Body

    {"convertedValue": "Value in words" }

Error Request Response Body

    {"error": "Error message" }

**dollarDigits variable requirements**
 `Defined value must be a dollar amount between 0-1000. Decimals are optional to define, but if defined, they must be exactly two decimal places to avoid ambiguity or other issues`


***

## Running

To run the app locally, Laravel will be required to be installed (and its supporting libraries). 

The command `php artisan serve` will launch the application on port 8000.

***

## Code of Conduct

`php artisan test` will run the applications [unit tests](tests/Unit).

***

## Structure

The API endpoint routes to the [convertor controller](app/Http/Controllers/Convertor.php).

The controller leans on a [service layer](app/Services/Convertor.php), which although not a standard Laravel architecture, 
this is following best deisgn practises found in most other languages (Jave, node.js, etc).

***

## Docker Image

The image for this repository can be found at https://hub.docker.com/repository/docker/darraghmcc/dollar-to-words

***

## Building the Docker Image

`Docker build . -t darraghmcc/dollar-to-words`


***

