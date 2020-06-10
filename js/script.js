/**
 **  DOM ELEMENTS
 */
const container = document.querySelector(".container");
const row = document.querySelector(".row");
const urlPosts = "http://localhost/API_test/post";
const urlCreateUser = "http://localhost/API_test/users"; //POST
const urlLogUser = "http://localhost/API_test/api/users/login.php"; //POST
const register = document.querySelector(".user-register");
const login = document.querySelector(".user-login");
const menu = document.querySelector(".menu");

/**
 ** FUNCTIONS
 */

const getData = () => {
    fetch(urlPosts)
        .then((res) => {
            // console.log(res);
            return res.json();
        })
        .then((data) => {
            let posts = data.data;
            // console.log(posts);

            for (let i = 0; i < posts.length; i++) {
                let postData = posts[i];
                let imgUrls = postData.img_url.split(",");

                let col = document.createElement("div");
                col.classList.add(
                    "col-md-6",
                    "col-sm-12",
                    "col-lg-4",
                    "col-xl-4",
                    "mb-4"
                );

                let cardDeck = document.createElement("div");
                cardDeck.setAttribute("style", "height: 100%;");
                cardDeck.classList.add("card-deck");

                let card = document.createElement("div");
                card.classList.add("card");

                let image = document.createElement("img");
                image.classList.add("card-img-top");
                image.setAttribute("style", "height: 250px;");
                image.setAttribute("src", `${imgUrls[0]}`);

                let cardBody = document.createElement("div");
                cardBody.classList.add("card-body");

                let cardTitle = document.createElement("h5");
                cardTitle.classList.add("card-title");
                cardTitle.innerHTML = `<span class="bold">${postData.title}</span>`;

                let cardText = document.createElement("p");
                cardText.classList.add("card-text");
                cardText.textContent = postData.body;

                let btnDetails = document.createElement("button");
                btnDetails.classList.add("btn", "btn-success", "m-2");
                btnDetails.textContent = "Details";

                let cardFooter = document.createElement("div");
                cardFooter.classList.add("card-footer");

                let cardFooterText = document.createElement("small");
                cardFooterText.classList.add("text-muted");
                cardFooterText.innerHTML = `
                Added on ${postData.creation_time} by <span class="bold">${postData.name}</span>`;

                card.append(image);

                cardBody.append(cardTitle);
                cardBody.append(cardText);

                card.append(cardBody);

                cardFooter.append(cardFooterText);
                cardFooter.append(btnDetails);
                card.append(cardFooter);
                cardDeck.append(card);

                col.append(cardDeck);
                row.append(col);

                btnDetails.addEventListener("click", () => {
                    // console.log(postData);
                    // document.querySelector(".container").innerHTML = " ";
                    document.querySelector(".row").innerHTML = " ";
                    getPost(postData.id);
                });
            }
        });
};
getData();
/**
 **                             Individual post
 * */
const getPost = (id) => {
    fetch(`http://localhost/API_test/post/${id}`)
        .then((res) => {
            return res.json();
        })
        .then((data) => {
            // console.log(data);
            const imgUrls = data.img_url.split(",");
            console.log(imgUrls);
            row.innerHTML = `
            <div class="col-md-7 mb-3 mt-5">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner swiper-container">
                        ${imgUrls.map((element) => {
                            const elem = element.split(",");
                            return (
                                '<div class="carousel-item swiper-wrapper" data-interval="3000"><img src="' +
                                elem +
                                '" class="d-block w-100 swiper-slide" alt="..."></div>'
                            );
                        })}
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        
        <div class="col-md-4 offset-md-1 ">
        <p class="new-arrival text-center">NEW</p>
        <h2>${data.title}</h2>
        <p>Product code: ${data.id}</p>
        <p>General Informations: </p>
        <hr>
        <p>Price: <b class="price">1500 &euro;</b></p>
        <p><b>Availability:</b> In stock</p>
        <p><b>Condition:</b> Used  <img src="img/stars.png" class="stars"></p>
        <p><b>Brand:</b> Kawasaki</p>
        <label>Quantity:</label>
        <input type="number" value="1">
        <a href="index.html" class="btn  cart">Add to cart</a>
    </div>
            `;
        });
};

const createUser = (data) => {
    fetch(urlCreateUser, {
        method: "POST",
        body: JSON.stringify(data),
    })
        .then((res) => res.json())
        .then((data) => {
            console.log(data);
        });
};

// const logUser = (data) => {
//     fetch(urlLogUser, {
//         method: "POST",
//         body: JSON.stringify(data),
//     })
//         .then((res) => res.json())
//         .then((data) => {
//             // console.log(data);
//             setCookie("jwt", data.jwt, 1);

//             container.innerHTML = " ";
//             changeMenuLoggedUser();
//             const div = document.createElement("div");
//             div.innerHTML = `
//             <div class="alert alert-success text-center" role="alert">
//                 Successfully logged in!
//             </div>`;
//             container.insertBefore(div, container.firstChild);
//         })
//         .catch((err) => {
//             console.log(err);
//         });
// };

const registerUser = (e) => {
    e.preventDefault();
    document.querySelector(".container").innerHTML = " ";
    // document.querySelector(".row").innerHTML = " ";

    row.innerHTML = `

    <div class="col-md-8 col-sm-10 col-lg-6 m-5 mx-auto">
        <!-- Default form register -->
        <form class="text-center border border-light p-5 bg-light " >
            <p class="h4 mb-4">Sign up</p>

            <div class="form-row mb-4">
                <div class="col">
                    <input type="text" id="name" class="form-control" placeholder="Enter your name">
                </div>
            </div>

            <!-- E-mail -->
            <input type="email" id="email" class="form-control mb-4" placeholder="Enter your E-mail">

            <!-- Password -->
            <input type="password" id="password" class="form-control mb-4" autocomplete="on" class="form-control" placeholder="Enter your password">

            <!-- Confirm Password -->
            <input type="password" id="confirm-password" autocomplete="on" class="form-control" placeholder="Confirm password">

            <!-- Sign up button -->
            <button class="btn btn-info my-4 btn-block waves-effect waves-light" type="button" id="btn-form">Sign in</button>

            <!-- Social register -->
            <p>or sign up with:</p>

            <a type="button" class="light-blue-text mx-2">
            <i class="fab fa-facebook-f"></i>
            </a>
            <a type="button" class="light-blue-text mx-2">
            <i class="fab fa-twitter"></i>
            </a>
            <a type="button" class="light-blue-text mx-2">
            <i class="fab fa-linkedin-in"></i>
            </a>
            <a type="button" class="light-blue-text mx-2">
            <i class="fab fa-github"></i>
            </a>

            <hr>

            <!-- Terms of service -->
            <p>By clicking
            <em>Sign up</em> you agree to our
            <a href="" target="_blank">terms of service</a>

        </p></form>
    </div>
    
    `;
    container.append(row);
    const nameValue = document.querySelector("#name");
    const emailValue = document.querySelector("#email");
    const passValue = document.querySelector("#password");
    const confirmPassValue = document.querySelector("#confirm-password");
    const btnForm = document.querySelector("#btn-form");

    btnForm.addEventListener("click", (e) => {
        e.preventDefault();
        const userData = {
            name: `${nameValue.value}`,
            email: `${emailValue.value}`,
            password: `${passValue.value}`,
        };

        if (passValue.value !== confirmPassValue.value) {
            passValue.classList.add("is-invalid");
            confirmPassValue.classList.add("is-invalid");
        } else {
            // createUser(userData);
            // loginUser();
        }
    });
};

const loginUser = (e) => {
    e.preventDefault();

    setCookie("jwt", "", 1);

    document.querySelector(".container").innerHTML = " ";

    row.innerHTML = `

    <div class="col-md-8 col-sm-10 col-lg-6 m-5 mx-auto ">
        <!-- Default form login -->
        <form class="text-center border border-light p-5 bg-light insert-err" >
            <p class="h4 mb-4">Sign in</p>


            <!-- E-mail -->
            <input type="email" id="email" class="form-control mb-4" placeholder="Enter your E-mail">

            <!-- Password -->
            <input type="password" id="password" class="form-control mb-4" autocomplete="on" class="form-control" placeholder="Enter your password">

            <!-- Sign in button -->
            <button class="btn btn-success my-4 btn-block waves-effect waves-light" type="button" id="btn-form-login">Sign in</button>

            <!-- Social register -->
            <p>or sign in with:</p>

            <a type="button" class="light-blue-text mx-2">
            <i class="fab fa-facebook-f"></i>
            </a>
            <a type="button" class="light-blue-text mx-2">
            <i class="fab fa-twitter"></i>
            </a>
            <a type="button" class="light-blue-text mx-2">
            <i class="fab fa-linkedin-in"></i>
            </a>
            <a type="button" class="light-blue-text mx-2">
            <i class="fab fa-github"></i>
            </a>

            <hr>

            <!-- Terms of service -->
            <p>By clicking
            <em>Sign up</em> you agree to our
            <a href="" target="_blank">terms of service</a>

        </p></form>
    </div>
    
    `;
    container.append(row);

    const emailValue = document.querySelector("#email");
    const passValue = document.querySelector("#password");
    const btnLogin = document.querySelector("#btn-form-login");

    btnLogin.addEventListener("click", (e) => {
        const userData = {
            email: `${emailValue.value}`,
            password: `${passValue.value}`,
        };

        fetch(urlLogUser, {
            method: "POST",
            body: JSON.stringify(userData),
        })
            .then((res) => {
                // res.json();
                if (!res.ok) {
                    const err = document.querySelector(".insert-err");
                    const div = document.createElement("div");
                    div.innerHTML = `
                        <div class="alert alert-warning" role="alert">
                            Invalid credentials!
                        </div>`;
                    err.insertBefore(div, err.firstChild);
                    // throw Error(res.statusText);
                    loginUser();
                }
                return res.json();
            })
            .then((data) => {
                const jwt = data.jwt;
                const item = JSON.stringify({ jwt });
                // console.log(item);
                setCookie("jwt", data.jwt, 1);
                showHomePage(item);
                container.innerHTML = " ";
                changeMenuLoggedUser();
                const div = document.createElement("div");
                div.innerHTML = `
                    <div class="alert alert-success text-center" role="alert">
                        Successfully logged in!
                    </div>`;
                container.insertBefore(div, container.firstChild);
            });
    });
};

const setCookie = (cname, cvalue, exdays) => {
    const d = new Date();
    d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
    const expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
};

const changeMenuLoggedUser = () => {
    login.classList.add("user-logout");
    login.classList.remove("user-login");
    login.textContent = "Logout";
    document.querySelector(".register").remove();
};

const showHomePage = (jwt) => {
    fetch("http://localhost/API_test/api/users/validate_token.php", {
        method: "POST",
        body: jwt,
    })
        .then((res) => {
            // console.log(res);
            return res.json();
        })
        .then((data) => {
            console.log(data);
        });
};

const getCookie = (cname) => {
    const name = cname + "=";
    const decodedCookie = decodeURIComponent(document.cookie);
    const ca = decodedCookie.split(";");
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == " ") {
            c = c.substring(1);
        }

        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
};

//Instantiate the SwiperJS class
var swiper = new Swiper(".swiper-container", {
    effect: "coverflow",
    grabCursor: true,
    centeredSlides: true,
    speed: 2500,
    autoplay: {
        delay: 3500,
        disableOnInteraction: false,
    },
    slidesPerView: "auto",
    loop: true,
    coverflowEffect: {
        rotate: 50,
        stretch: 0,
        depth: 100,
        modifier: 1,
        slideShadows: true,
    },
    pagination: {
        el: ".swiper-pagination",
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
});

register.addEventListener("click", registerUser);
login.addEventListener("click", loginUser);
// Get the current year for the copyright
$("#year").text(new Date().getFullYear());
