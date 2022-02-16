export default () => ({
    init() {

    },

    getRules() {
        if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            return {
                '.Label': {
                    color: 'rgb(156, 163, 175)',
                    fontWeight: 500,
                    fontSize: '0.875rem',
                    lineHeight: '1.25rem',
                },
                '.Input': {
                    backgroundColor: 'transparent',
                    color: 'rgb(229, 231, 235)',
                    borderRadius: '0.375rem',
                    fontSize: '1rem',
                    lineHeight: '1.5rem',
                    border: '1px solid rgb(55, 65, 81)',
                    boxShadow: 'rgba(0, 0, 0, 0) 0px 0px 0px 0px, rgba(0, 0, 0, 0) 0px 0px 0px 0px, rgba(0, 0, 0, 0.05) 0px 1px 2px 0px',
                }
            }
        } else {
            return {
                '.Label': {
                    color: 'rgb(55, 65, 81)',
                    fontWeight: 500,
                    fontSize: '0.875rem',
                    lineHeight: '1.25rem',
                },
                '.Input': {
                    backgroundColor: 'transparent',
                    borderRadius: '0.375rem',
                    fontSize: '1rem',
                    lineHeight: '1.5rem',
                    border: '1px solid rgb(209, 213, 219)',
                    boxShadow: 'rgba(0, 0, 0, 0) 0px 0px 0px 0px, rgba(0, 0, 0, 0) 0px 0px 0px 0px, rgba(0, 0, 0, 0.05) 0px 1px 2px 0px',
                }
            }
        }
    }
})


const stripe = Stripe("{{ config('services.stripe.key') }}");

let elements;

initialize();
checkStatus();

document
    .querySelector("#payment-form")
    .addEventListener("submit", handleSubmit);

// Fetches a payment intent and captures the client secret
async function initialize() {

    if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
        var rules = {
            '.Label': {
                color: 'rgb(156, 163, 175)',
                fontWeight: 500,
                fontSize: '0.875rem',
                lineHeight: '1.25rem',
            },
            '.Input': {
                backgroundColor: 'transparent',
                color: 'rgb(229, 231, 235)',
                borderRadius: '0.375rem',
                fontSize: '1rem',
                lineHeight: '1.5rem',
                border: '1px solid rgb(55, 65, 81)',
                boxShadow: 'rgba(0, 0, 0, 0) 0px 0px 0px 0px, rgba(0, 0, 0, 0) 0px 0px 0px 0px, rgba(0, 0, 0, 0.05) 0px 1px 2px 0px',
            }
        }
    } else {
        var rules = {
            '.Label': {
                color: 'rgb(55, 65, 81)',
                fontWeight: 500,
                fontSize: '0.875rem',
                lineHeight: '1.25rem',
            },
            '.Input': {
                backgroundColor: 'transparent',
                borderRadius: '0.375rem',
                fontSize: '1rem',
                lineHeight: '1.5rem',
                border: '1px solid rgb(209, 213, 219)',
                boxShadow: 'rgba(0, 0, 0, 0) 0px 0px 0px 0px, rgba(0, 0, 0, 0) 0px 0px 0px 0px, rgba(0, 0, 0, 0.05) 0px 1px 2px 0px',
            }
        }
    }

    elements = stripe.elements({
        clientSecret: @js($clientSecret),
        appearance: {
            theme: 'none',
            rules,
        }
    });

    var paymentElement = elements.create('payment', {
        fields: {
            billingDetails: {
                address: {
                    postalCode: 'never',
                    country: 'never',
                }
            }
        }
    });

    paymentElement.mount("#payment-element");
}

async function handleSubmit(e) {
    e.preventDefault();
    setLoading(true);

    const {
        error
    } = await stripe.confirmPayment({
        elements,
        confirmParams: {
            // Make sure to change this to your payment completion page
            return_url: "http://localhost:4242/public/checkout.html",
        },
    });

    // This point will only be reached if there is an immediate error when
    // confirming the payment. Otherwise, your customer will be redirected to
    // your `return_url`. For some payment methods like iDEAL, your customer will
    // be redirected to an intermediate site first to authorize the payment, then
    // redirected to the `return_url`.
    if (error.type === "card_error" || error.type === "validation_error") {
        showMessage(error.message);
    } else {
        showMessage("An unexpected error occured.");
    }

    setLoading(false);
}

// Fetches the payment intent status after payment submission
async function checkStatus() {
    const clientSecret = new URLSearchParams(window.location.search).get(
        "payment_intent_client_secret"
    );

    if (!clientSecret) {
        return;
    }

    const {
        paymentIntent
    } = await stripe.retrievePaymentIntent(clientSecret);

    switch (paymentIntent.status) {
        case "succeeded":
            showMessage("Payment succeeded!");
            break;
        case "processing":
            showMessage("Your payment is processing.");
            break;
        case "requires_payment_method":
            showMessage("Your payment was not successful, please try again.");
            break;
        default:
            showMessage("Something went wrong.");
            break;
    }
}

// ------- UI helpers -------

function showMessage(messageText) {
    const messageContainer = document.querySelector("#payment-message");

    messageContainer.classList.remove("hidden");
    messageContainer.textContent = messageText;

    setTimeout(function() {
        messageContainer.classList.add("hidden");
        messageText.textContent = "";
    }, 4000);
}

// Show a spinner on payment submission
function setLoading(isLoading) {
    if (isLoading) {
        // Disable the button and show a spinner
        document.querySelector("#submit").disabled = true;
        document.querySelector("#spinner").classList.remove("hidden");
        document.querySelector("#button-text").classList.add("hidden");
    } else {
        document.querySelector("#submit").disabled = false;
        document.querySelector("#spinner").classList.add("hidden");
        document.querySelector("#button-text").classList.remove("hidden");
    }
}
