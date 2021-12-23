describe("registration page",() => {
    
    it("redirects authenticated users elsewhere",() => {
        cy.login();
        cy.visit('signup').assertRedirect('settings/subscription/plan');
    });

    it("loads signup page",() => {
        cy.request('signup').its('status').should('eq',200);
    });

    it("allows a user to signup",() => {
        cy.visit('signup');
        cy.get("#username").type("testuser");
        cy.get("#email").type("testuser@example.com");
        cy.get("#password").type("testuser@123");

        cy.enterStripeCard();
        cy.contains("button","Register").click();

        cy.assertRedirect("/");
        cy.contains("Welcome to the club");

    });

    it("shows card declined error",() => {
        cy.visit('signup');
        cy.get("#username").type("testuser2");
        cy.get("#email").type("testuser2@example.com");
        cy.get("#password").type("testuser@123");

        cy.enterStripeCard({ approved: false });
        cy.contains("button","Register").click();

    
        cy.contains("Your card was declined");
    });

    describe("Validation",() => {
        it("shows username validations error",() => {
            cy.visit('/signup');
            cy.get('#username').type('test').tab(); 
            /*
                tab to move focus to next input 
                [ npm install -D cypress-plugin-tab] ;
                 and import it in cypress/support/index.js
            */
    
            cy.contains('Username taken');
        });
    
        it("shows email validations error",() => {
            cy.visit('/signup');
            cy.get('#email').type('email@example.com').tab(); 
            
            cy.contains('Email taken');
    
        });
    });

    

   
});