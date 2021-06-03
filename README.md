# BlogManagement.Laravel

## Overview

This repository contains **Blog Management** application for Laravel that shows design & coding practices followed by **[Differenz System](http://www.differenzsystem.com/)**.

The app does the following:
1. **Register** new account
2. **Login** user can login
3. **Make** new blogs
4. **Get**  User created blogs
5. **Get**  Blog detail by blog id
6. **Update** update blog by blog id
7. **Delete** delete blog by blog id


## Pre-requisites
- [ Visual Studio code](https://code.visualstudio.com/)
- [ Laravel 8.x](https://laravel.com/docs/8.x)
- [ MySql ](https://www.mysql.com/)
- [ Postman ](https://www.postman.com/)


## Getting Started
1. Install [Visual Studio code](https://code.visualstudio.com/) Editor.
2. Clone this sample repository in to the PHP configuration folder
3. Open Terminal, go to location of the repo
4. Install [Composer](https://getcomposer.org/). If you don't have a composer in the machine.
5. Enter command for install the 'Composer Update' (make sure to go inside project first). It will add required file in the Project.
   `` $composer update``
6. Create database and setup database name and user name on with apropriate password on.env file 
    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=laravel_project
    DB_USERNAME=root
    DB_PASSWORD=
 7. Enter following Command in CMD for create table in the database
    ``$php artisan migrate``


## Key Tools & Technologies
- **Database:** MySql
- **Authentication:** login
- **API/Service calls:** fetch API
- **IDE:**  VSCode
- **Framework:** Laravel

## Now call the API one by one.

### Register a new user
Registration: 
**POST URL: http://localhost/project_name/api/RegisterUser**

**Request:**
```
    {        
        "first_name":"test",
        "last_name":"differenzsystem",
        "email":"diff@differenzsystem.com",
        "password":"$atyam12345"
    }
```

**Validation Response:**
```
	{
        "success": false,
        "status_code": 200,
        "message": "Validation run successfully!",
        "data": {
            "email": "The email has already been taken."
        }
    }
```
**Success Response:**
```
	{
        "success": true,
        "status_code": 200,
        "message": "User registration successdully!",
        "data": {
            "first_name": "test",
            "last_name": "differenzsy stem",
            "email": "diffe@differenzsystem.com",
            "updated_at": "2021-05-28T10:37:42.000000Z",
            "created_at": "2021-05-28T10:37:42.000000Z",
            "id": 2
        }
    }
```

### login API:

**POST URL: http://localhost/project_name/api/login**

**Request:**
```
     {        
            "email":"diffe@differenzsystem.com",
            "password":"$atyam12345"
    }
```
**Email Validation Response:**
```
    {
        "success": false,
        "status_code": 200,
        "message": "User email not found!",
        "data": {}
    }
```
**Password Validation Response:**
```
    {
        "success": false,
        "status_code": 200,
        "message": "User password not valid!",
        "data": {}
    }
```


**Success Response:**
```
    {
        "success": true,
        "status_code": 200,
        "message": "Login successdully!",
        "data": {
            "id": 2,
            "first_name": "test",
            "last_name": "differenzsystem",
            "email": "diffe@differenzsystem.com",
            "created_at": "2021-05-28T10:37:42.000000Z",
            "updated_at": "2021-05-28T10:37:42.000000Z"
        }
    }
```
### Make new blog API:
create a new blog for login user

**POST URL: http://localhost/project_name/api/blog/store/{login_user_id}**

**Request:**
```
    {
        "title":"Dummy",
        "description":"Hay dummy wahtsapp",
        "tags":"dummy,demo,hay,wahtsapp"
    }
```

**Response:**
```
    {
        "success": true,
        "status_code": 200,
        "message": "Successfully store your blog",
        "data": {
            "title": "Dummy",
            "description": "Hay dummy wahtsapp",
            "tags": "dummy,demo,hay,wahtsapp",
            "user_id": 1,
            "status": 1,
            "updated_at": "2021-05-28T10:45:15.000000Z",
            "created_at": "2021-05-28T10:45:15.000000Z",
            "id": 7
        }
    }
```

### Get Blog List API:
get all blog list of login user

**GET URL: http://localhost/project_name/api/blog/{login_user_id}**

**Response:**
```
   {
        "success": true,
        "status_code": 200,
        "message": "My blogs list!",
        "data": [
            {
                "id": 2,
                "user_id": 1,
                "title": "Demo",
                "description": "Hay demo wahtsapp",
                "status": 1,
                "tags": "demo,hay,wahtsapp",
                "created_at": "2021-04-13T06:00:05.000000Z",
                "updated_at": "2021-04-13T06:00:05.000000Z"
            },
            {
                "id": 3,
                "user_id": 1,
                "title": "aa",
                "description": "Hay dummy wahtsapp",
                "status": 1,
                "tags": "dummy,demo,hay,wahtsapp",
                "created_at": "2021-04-13T07:26:26.000000Z",
                "updated_at": "2021-04-13T07:26:26.000000Z"
            }
        ]
    }
```


### Get Blog details API:
get single blog details use blog id

**GET URL: http://localhost/project_name/api/blog/show/{blog_id}**

**Response:**
```
   {
        "success": true,
        "status_code": 200,
        "message": "Successfully get blog",
        "data": {
            "id": 2,
            "user_id": 1,
            "title": "Demo",
            "description": "Hay demo wahtsapp",
            "status": 1,
            "tags": "demo,hay,wahtsapp",
            "created_at": "2021-04-13T06:00:05.000000Z",
            "updated_at": "2021-04-13T06:00:05.000000Z"
        }
    }
```

### Update blog API:
update a new blog use blog id

**POST URL: http://localhost/project_name/api/blog/update/{blog_id}**

**Request:**
```
    {
        "title":"Dummy update",
        "description":"Hay dummy wahtsapp update",
        "tags":"dummy,demo,hay,wahtsapp,update"
    }
```

**Response:**
```
    {
        "success": true,
        "status_code": 200,
        "message": "Successfully update your blog",
        "data": null
    }
```

### Delete Blog API:
delete blog use blog if

**DELETE URL: http://localhost/project_name/api/blog/delete/{blog_id}**

**Response:**
```
   {
    "success": true,
    "status_code": 200,
    "message": "Successfully deleted your blog",
    "data": []
}
```


## Support
If you've found an error in this sample, please [report an issue](https://differenz-system:welcome007@github.com/differenz-system/AddressBook.Laravel.git).  You can also send your feedback and suggestions at info@differenzsystem.com

Happy coding!

