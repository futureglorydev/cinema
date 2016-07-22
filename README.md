cinema
======

cinema test

It is necessary to implement REST-like API for the purchase of movie tickets.

There are several theaters, in which each of several rooms. In them there is a number of films, some films in several rooms of different theaters simultaneously. The film has sessions, the main feature of which is the session time. Also a certain number of seats in each hall.

It is necessary to allow the user to view the theater schedule, with the possibility of filtering the room:

GET / api / cinema / <name Cinema> / schedule [? Hall = hall number]

You should also give the opportunity to view public theaters / halls there is a specific film?

GET / api / film / <movie name> / schedule

Then it is necessary to check which places are free for a specific session:

GET / api / session / <id session> / places

And give the possibility to buy a ticket:

POST / api / tickets / buy? Session = <id session> & places = 1,3,5,7

The result of the query must have a unique code, which characterizes this set of tickets

And to cancel the purchase, but not earlier than one hour before the start of the session:

POST / api / tickets / reject / <unique ID>
