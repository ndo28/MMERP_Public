C & C Architecture Diagram README

Nathan Ortolan (ndo28)
Becky Williams (rjw125)
Abdul Shaikh (ats234)
Guthrie Hayward (gmh234)
last modified: 12/3/16 - ndo28

This pdf contains both a Surveyor and an Administrator Component Connector Architecture
Diagram in a client server style:
  -Components-
    Client -        Admin/Surveyor (ovals)
    Server -        mmerp.php's modules on nrs-projects (rectangles)
    Database -      Student Oracle SQL database (cylinders)
  -Connectors-
    Dotted lines -  client-server interaction
    Solid lines -   server-database interactions OR
                    server-server(method-to-method) interactions

This model is intended to depict the flow of data through the MMERP web app, from
client to server to database and back.

While both types of users gain access to the rest of the application by using the
validate_user() server method, the rest of their activity will be distinct. For
this reason, they will be depicted as two separate modules.
