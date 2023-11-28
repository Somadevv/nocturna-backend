const car = 0;

function returnsSomething(year) {
    return Math.ceil(year);
}
console.log(returnsSomething(1000));

function setCarValue(year) {
    let result = year / 10 + 5;
    car = result;
}

console.log(car);

setCarValue(5600000000);

console.log(car);
