CREATE TABLE books (
    id INTEGER PRIMARY KEY,
    isbn INTEGER NOT NULL,
    author TEXT NOT NULL,
    title TEXT NOT NULL,
    description TEXT NOT NULL,
    publicationdate INTEGER NOT NULL,
    rating INTEGER NOT NULL
);
 
INSERT INTO books (isbn, author, title, description, publicationdate, rating)
    VALUES ('1111111111111', 'Lorem ipsum', 'Lorem ipsum', 'Sed rutrum leo nec tincidunt sollicitudin',1998,8);
INSERT INTO books (isbn, author, title, description, publicationdate, rating)
    VALUES ('7777777777777', 'Quis autem', 'quia consequuntur', 'ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur',2005,7);
INSERT INTO books (isbn, author, title, description, publicationdate, rating)
    VALUES ('5555555555555', 'quas molestia', 'Lorem ipsum', 'Itaque earum rerum hic tenetur a sapiente delectus',2008,5);
INSERT INTO books (isbn, author, title, description, publicationdate, rating)
    VALUES ('9876543210987', 'irure dolor', 'Lorem ipsum', 'reprehenderit qui in ea voluptate',2009,10);
INSERT INTO books (isbn, author, title, description, publicationdate, rating)
    VALUES ('0123456789123', 'dolorum fuga', 'Lorem ipsum', 'expedita distinctio. Nam libero tempor',2010,3);