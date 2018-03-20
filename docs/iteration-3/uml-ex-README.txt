UML entity-relation diagram

Nathan Ortolan (ndo28)
Becky Williams (rjw125)
Abdul Shaikh (ats234)
Guthrie Hayward (gmh234)
last modified: 12/3/16 - ndo28

This pdf contains a UML entity-relation diagram. This model is intended to depict
entities and the relations between them in the MMERP database.
  -Entities-
    Consist of an entity name, a primary key (PK), possibly foreign key(s) (FK),
    and other columns, all including data types.
  -Relations-
    Consist of a relation description(name), and the number of entities that
    participate in a relation from both entities involved.(0,1,M,0..M)

We chose to create a UML entity-relation diagram because an actual ERD is not
considered to be a UML diagram. A traditional ERD would probably be the most
useful diagram to model our web application since most of the complication
comes from client->server->database transactions.
