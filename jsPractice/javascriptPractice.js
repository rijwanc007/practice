const objOne = new Object({
    name        : 'rijwan',
    profession  : 'software engineer'
});

console.log(objOne.name + ' ' + objOne.profession);

//the Object.create() method creates an object from an existing object
const objTwo = {
    firstName : 'rijwan',
    lastName  : 'chowdhury',
    language  : 'en'
}

const objThree = Object.create(objTwo);
objThree.firstName  = 'Younusur';

console.log(objTwo.firstName + " and " + objThree.firstName);

//the fromEntries() method creates an object from iterable key/value paris
const aryOne = [
    ['apples',300],
    ['pears',900],
    ['bananas',500]
];

const aryOneObj = Object.fromEntries(aryOne);
console.log(aryOneObj.bananas);