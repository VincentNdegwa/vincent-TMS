<template>
    <div class="verified-page">
        <div class="content">
            <h1>Email Not Verified!</h1>
            <p>{{ reason }}</p>
            <a href="/verification_retry">Retry</a>
        </div>
    </div>
</template>

<script>
export default {

    name: 'NotVerifiedPage',
    props: {
        reason: String,
    },
};
</script>

<style>
/* Style for the component */
.verified-page {
    background-color: var(--light-dark);
    color: var(--white);
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}

.content {
    text-align: center;
    max-width: 700px;
}

.content>h1 {
    color: var(--orange);
    font-size: 3rem;
}

.content>p {
    color: var(--white);
    font-size: 2rem;
}

.content>a {
    background: var(--orange);
    padding: 0.5rem;
    border-radius: 0.5rem;
}

.btn {
    display: inline-block;
    padding: 10px 20px;
    margin-top: 20px;
    color: var(--white);
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.btn:hover {
    background-color: var(--black);
}

@media screen and (max-width:700px) {
    .content {
        max-width: 100% !important;
    }
}

@media screen and (max-width:500px) {

    .content>h1 {
        font-size: 2.5rem;
    }

    .content>p {
        font-size: 2rem;
    }

}
</style>
