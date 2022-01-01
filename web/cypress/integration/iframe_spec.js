Cypress.Commands.add('getIframe', () => {
    return cy
            .get('iframe')
            .its('0.contentDocument.body')
            .should('not.be.empty')
            .then(cy.wrap);
});

it('works with iframes', () => {

    cy.visit('/');

    cy.getIframe()
        .find('#iframe-button')
        .should("have.text", "Click me!");
});