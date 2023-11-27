function Product(prodID, price) {
    this.prodID = prodID;
    this.price = price;

    this.changePrice = function (discount) {
        this.price -= discount;
    };
}

let glue = new Product();

glue.changePrice(2);
