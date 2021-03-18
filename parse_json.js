var fs=require('fs');
var words;

fs.readFile("/uploads/data.json",'utf-8',
    function(error,data){
        console.log("Асинхронное чтение файла");
        if(error) throw error; // если возникла ошибка
       // console.log(data);  // выводим считанные данные
        words=JSON.parse(data);
        console.log(words);
        //console.log(words.IONIZATION_POTENCIAL)
    });
