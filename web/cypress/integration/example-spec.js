describe('Blog',() => {
    
    beforeEach(() => {
        cy.refreshDatabase()
    });

    it("works",() => {
        cy.visit("/").contains('MoneyTracker');
    });


    it('shows all posts',() => {
        cy.create('App\\Post',3,{
            title: 'My First Post',
        });

        cy.php(`
            App\\Post::count()
        `).then(count => {
            cy.log('The count of posts is '+count)
        });

        cy.visit('/blog',{
            failOnStatusCode: false
        }).contains('My First Post');
    });

});


 