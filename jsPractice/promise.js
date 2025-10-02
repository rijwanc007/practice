(function() {
    console.log('these input is going for test purpose');
})();

let myPromise = new Promise((resolve,reject) => {

    let success = true;
    if(success) {

        resolve('operation successful');
    } else {

        reject('operation failed');
    }
});

myPromise
    .then((message) => console.log(message))
    .catch((error) => console.log(error));

const myPromiseTwo = new Promise((resolve,reject) => {
    setTimeout(() => {
        const randomNumber = Math.random();
        if(randomNumber < 0.5) {
            resolve("Data has been successfully retrieved")
        } else {
            reject("An error occurred while fetching data");
        }
    } ,1000)
});

myPromiseTwo
    .then((data) => {
        console.log(data);
    })
    .catch((error) => {
        console.log(error);
    })

//Promise.resolve() in javascript is a static method that returns a Promise
//object that is resolved with a given value,its primary uses are:creating an already resolved promise
//if you need a Promise that immediately fulfills with a specific value, Promise.resolve()
//provides a concise way to achive this
//the Promise.all() method returns a single Promise from a list of promises,
//when all promises fulfill

const promiseOne   = Promise.resolve(123);
const promiseTwo   = 456;
const promiseThree = new Promise((resolve,reject) => {
    setTimeout(resolve,1000,'foo');
});

Promise.all([promiseOne,promiseTwo,promiseThree]).then((values) => {
    console.log(values);
});

//the Promise.race() method returns a Promise from a list of promises,
//when the faster promise settles

const promiseFour = new Promise((resolve,reject) => {
    setTimeout(resolve,500,'one');
});

const promiseFive = new Promise((resolve,reject) => {
    setTimeout(resolve,100,'two');
});

Promise.race([promiseFour,promiseFive]).then((value) => {
   console.log(value);
});

//the Promise.allSettled() method returns a single Promises,
//when all promises settled

const promiseSix = new Promise((resolve,reject) => {
    setTimeout(resolve,200,'king');
});

const promiseSeven = new Promise((resolve,reject) => {
    setTimeout(resolve,100,'queen');
});

Promise.allSettled([promiseSix,promiseSeven]).then((values) => {
    console.log(values);
});

//the Promise.any() method returns a single Promise from a list of promises,
//when any promise fulfill

const promiseEight = new Promise((resolve,reject) => {
    setTimeout(resolve,200,'ridhan');
});

const promiseNine = new Promise((resolve,reject) => {
    setTimeout(resolve,100,'rijwan');
})

Promise.any([promiseEight,promiseNine]).then((values) => {
    console.log(values);
})

//.then() , .catch() , .finally() method use case

let myPromiseThree = new Promise((resolve,reject) => {

    let success = true;
    if(success) {

        resolve('operation completed successfully');
    } else {

        reject('something went wrong');
    }
});

myPromiseThree
    .then( (message) => {

        console.log(message);
    })
    .catch( (error) => {

        console.log(error);
    })
    .finally( () => {

        console.log('promise operation finished');
    });

// web api fetch function used

let urlLink = "https://fake-json-api.mock.beeceptor.com/users";

fetch(urlLink)
.then((response) => response.json())
.then((data) => {
    console.log(data);
});

//async and await make promises easier to write
//async makes a function return a Promise
//await makes a function wait for a Promise
async function asyncFetchData(url) {

    const response = await fetch(url);
    return await response.json();
}

asyncFetchData(urlLink)
.then((data) => {
    console.log(data);
})

//async and await using try catch

const myPromiseFour = new Promise((resolve,reject) => {

    setTimeout(function() {
        let error = false;
        if(!error) {

            resolve({
                username : "javascript",
                password : "12345"
            });
        } else {

            reject('error : js went wrong');
        }
    },1000);
});

async function consumePromiseFour() {
    try {

        let response = await myPromiseFour;
        console.log(response);
    } catch (error) {

        console.log(error);
    }
}

consumePromiseFour();

(async function() {

    try {

        let response = await myPromiseFour;
        console.log(response);
    } catch (error) {

        console.log(error);
    }
})();

// more understandable structure

function fetchData(url) {

    return new Promise( (resolve,reject) => {

        fetch(url)
            .then(response => {
                if(response.ok) {

                    return response.json();
                } else {

                    throw new Error('network response was not ok');
                }
            })
            .then( (data) => {

                resolve(data);
            })
            .catch( (error) => {

                reject(error);
            })
    })
}

fetchData(urlLink)
    .then( (data) => {

        console.log(data);
    })
    .catch( (error) => {

        console.log(error);
    })
