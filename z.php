<?php 
phpinfo();	
0103066761

/*creat forign key*/
CREATE TABLE wesia(
	id int not null,
    username varchar(255) unique,
    email varchar(255) unique,
    PRIMARY KEY(id)
) ENGINE = INNODB;

/**/
CREATE TABLE orders(
	order_id int not null,
    price varchar(255),
    wesia_id int not null,
	PRIMARY KEY(order_id),
    FOREIGN KEY(wesia_id) REFERENCES wesia(id)
)ENGINE = INNODB;

/* creat fogign key when data base exist */
//sqp in table users 
ALTER TABLE users
ADD CONSTRAINT ordering
FOREIGN KEY(id) REFERENCES person(wesia)
ON UPDATE CASCADE
ON DELETE CASCADE;

/*join*/
SELECT * FROM `orders`
JOIN client ON
client.client_id = orders.num
WHERE client.client_id = 1


/*creat table*/
CREATE TABLE shops(
	shop_id int not null PRIMARY KEY,
    name varchar(255)
    
    

) ENGINE = INNODB;


/*many to many*/
CREATE TABLE membershop(
client int not null,
    shop int not null,
    PRIMARY key(client, shops),
  CONSTRAINT cons_client
    FOREIGN KEY (client) REFERENCES client(client_id)
    ON DELETE CASCADE ON UPDATE CASCADE,
      CONSTRAINT cons_shop
    FOREIGN KEY (shop) REFERENCES shops(shop_id)
     ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = INNODB;

/*select */
SELECT * FROM client JOIN membershop ON client.client_id = membershop.client
WHERE membershop.shop = 1; 



    //TRIGGER THE SELECT BOX
    /* ("select").selectBoxIt();
    $('[placeholder]').focus(function(){

        $(this).attr('data-text', $(this).attr('placeholder'));
        $(this).attr('placeholder', '');
    })
    .blur(function(){
        $(this).attr('placeholder', $(this).attr('data-text'));

    });*/

    //add asterrisk on required field

    /*$('input').each(function()
    {
        if ($(this).attr('required') === 'required')
        {
            $(this).after('<span class="asterisk">*</span>');

        }
    });*/