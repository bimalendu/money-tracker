describe("Login", () => {
    before(()=>{
        cy.refreshDatabase().seed();
        cy.create('App\\User',{
            username: 'JohnDoe',
            email: 'john@example.com',
            password: 'example'
        });
    });

    beforeEach(()=>{
        cy.visit("/").contains("a","Sign In").click();
    });

    context("With valid credentials", () => {
        it('works',() => {
            cy.get("#email").type("john@example.com");
            cy.get("#password").type("example");

            cy.contains("button", "Login").click();
            cy.contains("Login Successful");
            cy.visit('/settings/account').contains('Update your account'); //inner private page
        });
    });

    context("With invalid credentials", () => {
        it('requires a valid email address',() => {
            cy.get("#email").type("foobar");
            cy.get("#password").focus();
            cy.contains("The email address is not valid");
        });

        it('requires an existing email address',() => {
            cy.get("#email").type("foobar");
            cy.get("#password").focus();
            cy.contains("The provided email address doesnot exist");
        });
        it('requires valid credentials',() => {
            cy.get("#email").type("john@example.com");
            cy.get("#password").type("invalidpassword");

            cy.contains("button", "Login").click();
            cy.contains("We couldn't verify your credentials");
        });
    });

    
});