describe("Stub a network request", () => {
   
        cy.server();
        cy.route("/posts",[
            "title": "Hello world"
        ]); //fake the network request when you need to mimic 3rd party api behavior

        /*
            cy.route("/posts",'fixture:posts'); 
        */

        /*
            cy.route("/posts").as("getPosts"); //alias the route
            cy.wait("@getPosts").then(xhr => {
                cy.writeFile("cypress/fixtures/posts.json", xhr.responseBody);
            }); 
            //wait for the route to resolve and write it to posts fixture so that it can be reused later           
        */
        cy.visit('/blog');
    
});