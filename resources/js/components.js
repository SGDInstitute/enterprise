import { Tabs, Tab } from 'vue-tabs-component';

Vue.component('tabs', Tabs);
Vue.component('tab', Tab);

Vue.component('alert', require('./components/Alert.vue').default);
Vue.component('add-user-button', require('./components/AddUserToTicketButton.vue').default);
Vue.component('donation-form', require('./components/DonationForm.vue').default);
Vue.component('contribution-checkout', require('./components/ContributionCheckout.vue').default);
Vue.component('contribution-form', require('./components/ContributionForm.vue').default);
Vue.component('contribution', require('./components/Contribution.vue').default);
Vue.component('edit-profile', require('./components/EditProfile.vue').default);
Vue.component('edit-password', require('./components/EditPassword.vue').default);
Vue.component('edit-invoice-button', require('./components/EditInvoiceButton.vue').default);
Vue.component('create-invoice-button', require('./components/CreateInvoiceButton.vue').default);
Vue.component('invoice-form', require('./components/InvoiceForm.vue').default);
Vue.component('invite-users-form', require('./components/InviteUsersForm.vue').default);
Vue.component('login-or-register', require('./components/LoginOrRegister.vue').default);
Vue.component('manual-user-modal', require('./components/ManualUserModal.vue').default);
Vue.component('modal', require('./components/Modal.vue').default);
Vue.component('modal-button', require('./components/ModalButton.vue').default);
Vue.component('pay-with-card', require('./components/PayWithCard.vue').default);
Vue.component('pay-with-check', require('./components/PayWithCheck.vue').default);
Vue.component('receipt-button', require('./components/ReceiptButton.vue').default);
Vue.component('remove-user-button', require('./components/RemoveUserButton.vue').default);
Vue.component('start-order', require('./components/StartOrder.vue').default);
Vue.component('update-card-button', require('./components/UpdateCardButton.vue').default);
Vue.component('view-invoice-modal', require('./components/ViewInvoiceModal.vue').default);
Vue.component('view-receipt-modal', require('./components/ViewReceiptModal.vue').default);
Vue.component('view-invoice-button', require('./components/ViewinvoiceButton.vue').default);
Vue.component('view-profile-modal', require('./components/ViewProfileModal.vue').default);
Vue.component('dynamic-form', require('./components/voyager/DynamicForm.vue').default);

Vue.component('pay-tour', require('./components/PayTour.vue').default);
Vue.component('invite-tour', require('./components/InviteTour.vue').default);