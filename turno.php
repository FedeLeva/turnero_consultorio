

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Formulario</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&family=Roboto:wght@500&display=swap"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="//cdn.jsdelivr.net/npm/element-plus/dist/index.css"
    />
    <link rel="stylesheet" href="styles/schedule.css">
    <script src="https://unpkg.com/vue@3"></script>

    <!-- Import component library -->
    <script src="//cdn.jsdelivr.net/npm/element-plus"></script>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
    />


    <script src="https://cdn.jsdelivr.net/npm/dayjs@1/dayjs.min.js"></script>
    <link rel="stylesheet" href="styles/calendar.css" />
    <link rel="stylesheet" href="styles/confirmPayment.css" />
    <link rel="stylesheet" href="styles/form.css" />
    <link rel="stylesheet" href="styles/schedule.css" />
    <link rel="stylesheet" href="styles/turn.css" />
    <link rel="stylesheet" href="styles/userForm.css" />
    <link rel="stylesheet" href="">
    <script src="app.js"></script>
    <script src="components/calendar.js"></script>
    <script src="components/turn.js"></script>
    <script src="components/schedule.js"></script>
    <script src="components/userForm.js"></script>
    <script src="components/confirmPayment.js"></script>
    <script>
      document.addEventListener("DOMContentLoaded", () => {
        App.mount("#formulario");
        document.querySelector("#formulario").classList.remove("hidden")
      });
    </script>
        <style>
          /* Global tags */
              * {
                margin: 0px;
                padding: 0px;
                box-sizing: border-box;
              }
              *, *:before, *:after {
    -moz-box-sizing: border-box;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
  }
              body {
                font-size: 1.5em;
    font-weight: 100;
              }
              img {
                width:100%;
              }
              p {
                font-family: "Open Sans", sans-serif;
                font-size: 16px;
                color: #82848e;
              }
  
              h1,
              h2,
              h3,
              h4,
              h5,
              h6,
              a {
                font-family: "Roboto", sans-serif;
                font-size: 20px;
                color: #353536;
              }

              li {
      text-decoration: none;
      list-style: none;
  }
              /* Wsap */
              .logoWsap {
                background: red;
                height: 70px;
                width: 70px;
                position: fixed;
                right: 25px;
                bottom: 10px;
                border-radius: 50%;
                background-color: #25d366;
                background-image: url("whatsapp-symbol-logo-svgrepo-com.svg");
                background-repeat: no-repeat;
                background-position: center;
                transition: background-color 0.5s;
                z-index: 100000;
              }
  
              .logoWsap:hover {
                cursor: pointer;
                background-color: #2bb741;
              }
  
        
     /* Buttons */
              .form__btnNext {
             
                min-width: 100px;
                height: 40px;
                margin-right: 20px;
                width: 130px;
                border-radius: 5px;
                font-size: 15px;
                font-family: "Roboto", sans-serif;
                border: none;
                background: #ccd6a6;
                color: #393646;
                font-weight: 500;
                transition: background 0.5s;
                border: #b3c99c 1px solid;
              }
              .form__btnNext:hover {
                background: #dae2b6;
                cursor: pointer;
              }
  
              .form__btnNext--disabled {
  
        
                background: #e1eedd !important;
                border: none;
                cursor: not-allowed !important;
              }
          
           
  
     /* SectionForm */
              .sectionForm {
                display: flex;
                  width: 60%;
                  margin: auto;
                  text-align: center;
                  box-shadow: 0 30px 40px #f0f0f0;
              }
         /* Values */
              .values {
                width: 30%; background-color: #86c8bc; border-radius: 3px
              }
  


   
              .values__valuesContainer {
   
              min-height: 100px;
              padding-bottom:20px;
               }


              .values__valuesContainer--paddingTop {
        
  
                   padding-top: 20px;
               }
  
  
  
              
            .values__titleContainer {
                 display: flex;
                 justify-content: space-between;
                 height: 30px;
             }
  
  
            
     .values__title {
  
      
       padding-left: 10px; margin: auto; width: 80%;
  
  
     }
  
     .values__text {
    
               font-family: "Roboto", sans-serif;
               color: #fff;
               font-size: 18px;
               font-weight: 400;
  
               
             }
  

     .values__readyContainer {
  
     
       margin-right: 30px; display: flex
  
  
  
     }
  
     .values__circle {
       
       border: 4px solid #000;
                     border-radius: 50%;
                     display: flex;
                     margin: auto;
                     width: 24px;
                     height: 24px;
                     position: relative;
  
  
                     
     }
  
     .values__ready {
  
       
       position: absolute;
                       top: 50%;
                       left: 50%;
                       transform: translate(-50%, -50%);
  
  
                       
     }
  
     .values__value {
    
       
       font-size: 15px;
      
                 padding-top: 5px;
                 text-align: left;
                 margin-left: 10px;
  
  
                 
         
     }
  
     .values__value--capitalize {
       text-transform: capitalize;
     }
     .values__circle--ready {
           
           outline: 3px solid #2C3639;
  
         }
  /* Form */
  .form {
    width: 70%
  }

  .form__backButtonContainer {
    padding-bottom: 10px;
        padding-top: 5px;
        box-shadow: 0 2px 2px #f0f0f0;
        text-align: left;
        padding-left: 20px;
        display: flex;
  }
  
  .form__btnPageBack {
height: 24px; width: 24px; margin-right: 10px
}

.form__pageContent {
height: 444px; overflow: auto; padding-top: 5px
}

.form__nextButtonContainer {



padding-bottom: 20px;
        padding-top: 20px;

        display: flex;
        justify-content: flex-end;
        box-shadow: 0 -2px 3px #f0f0f0;
}
            /* Banner */

     
            .bannerContainer {
              text-align: center; margin: auto;width:100%;
              max-width: 300px;
            }
  
            .bannerTitle {
              font-size: 1.8em; color: #8b1e3f; margin-bottom: 50px
            }
  
      /* Copyright */
      .copyright {
        height: 50px;
          text-align: center;
          display: flex;
          background: #f1dede;
          margin-top: 20px;
      }
  
      .copyright__text {
        margin: auto; font-size: 16px; color: #343837
      }
           /* Modifiers */
      .hidden {
        visibility: hidden
      }

      /* Responsive */
            @media(max-width:1208px) {
              .sectionForm {
                width: 80%;;
              }
            }
  
            @media(max-width:910px) {
              .sectionForm {
                width: 90%;;
              }
            }
        
            @media(max-width:810px) {
              .sectionForm {
                width: 95%;;
              }
            }
  
            @media(max-width:770px) {
               .sectionForm {
                flex-direction: column;
               }
  
               .values {
                display: none;
               }
  
               .form {
                width:95%;
               }
            }
       
  
      
            @media(max-width:201px) {
              .bannerTitle {
                font-size: initial;
              }
  
           
  
  
  
            }
  
  

      @media (max-width: 176px) {
 
        h1 , h2 , h3 , h4 , h5 , h6 {
          font-size:13px;
        }
  
        .form__backButtonContainer {
          padding-left:0;
        }
      }
  
  

      </style>
  </head>
  <body>
    <div class="logoWsap"></div>
    <div class="bannerContainer">
      <img src="banner.jpg" alt="" />
      <h1 class="bannerTitle">RESERVA TU TURNO</h1>
    </div>
    <div id="formulario" class="hidden">
     
  
      <section class="sectionForm">
        <div class="values">
          <div class="values__valuesContainer values__valuesContainer--paddingTop" >
            <div
              class="values__titleContainer" 
           
            >
              <h2
              
                class="values__title values__text"
               
              >
                Tu turno
              </h2>
              <div class="values__readyContainer" >
                <div
                  :class="{      values__circle : true , 'values__circle--ready' : this.turns.completedFields.turn && this.turns.current == 1 }"
                >
                  <svg
                    v-if="this.turns.completedFields.turn"
                    class="values__ready"
                    fill="#000000"
                    height="24px"
                    width="24px"
                    version="1.1"
                    id="Layer_1"
                    xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink"
                    viewBox="0 0 512 512"
                    xml:space="preserve"
                  >
                    <g>
                      <g>
                        <path
                          d="M256,0C114.837,0,0,114.843,0,256s114.837,256,256,256s256-114.843,256-256S397.163,0,256,0z M376.239,227.501
                   L257.348,346.391c-13.043,13.043-34.174,13.044-47.218,0l-68.804-68.804c-13.044-13.038-13.044-34.179,0-47.218
                   c13.044-13.044,34.174-13.044,47.218,0l45.195,45.19l95.282-95.278c13.044-13.044,34.174-13.044,47.218,0
                   C389.283,193.321,389.283,214.462,376.239,227.501z"
                        />
                      </g>
                    </g>
                  </svg>
                </div>
              </div>
            </div>

            <p
              :class="{'values__value--capitalize' : true , values__value : true ,'values__text' : true , animate__animated : true , animate__fadeInRight : valueModality }   "
            >
              {{valueModality}}
            </p>
            <p
              :class="{'values__value--capitalize' : true , 'values__value' : true ,  'values__text' : true , animate__animated : true , animate__fadeInRight : valueMeeting }"
           
            >
              {{valueMeeting}}
            </p>
          </div>
          <div  class="values__valuesContainer">
            <div
             class="values__titleContainer"
            >
              <h2
                class="values__text values__title"
                
              >
                Fecha y Hora
              </h2>
              <div class="values__readyContainer">
                <div
                
                  :class="{values__circle : true , 'values__circle--ready' : this.turns.completedFields.calendar && this.turns.current == 2 }"
                >
                  <svg
                    v-if="this.turns.completedFields.calendar"
                   class="values__ready"
                    fill="#000000"
                    height="24px"
                    width="24px"
                    version="1.1"
                    id="Layer_1"
                    xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink"
                    viewBox="0 0 512 512"
                    xml:space="preserve"
                  >
                    <g>
                      <g>
                        <path
                          d="M256,0C114.837,0,0,114.843,0,256s114.837,256,256,256s256-114.843,256-256S397.163,0,256,0z M376.239,227.501
                 L257.348,346.391c-13.043,13.043-34.174,13.044-47.218,0l-68.804-68.804c-13.044-13.038-13.044-34.179,0-47.218
                 c13.044-13.044,34.174-13.044,47.218,0l45.195,45.19l95.282-95.278c13.044-13.044,34.174-13.044,47.218,0
                 C389.283,193.321,389.283,214.462,376.239,227.501z"
                        />
                      </g>
                    </g>
                  </svg>
                </div>
              </div>
            </div>

            <p
              :class="{'values__value--capitalize' : true , values__value : true , 'values__text' : true , animate__animated : true , animate__fadeInRight : valueSchedule }   "
             
            >
              {{valueSchedule}}
            </p>
          </div>
          <div class="values__valuesContainer">
            <div
              class="values__titleContainer"
            >
              <h2
                class="values__text values__title"
               
              >
                Tu info
              </h2>
              <div class="values__readyContainer">
                <div
                 
                  :class="{values__circle : true , 'values__circle--ready' : this.turns.completedFields.information && this.turns.current == 3 }"
                >
                  <svg
                    v-if="this.turns.completedFields.information"
                   class="values__ready"
                    fill="#000000"
                    height="24px"
                    width="24px"
                    version="1.1"
                    id="Layer_1"
                    xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink"
                    viewBox="0 0 512 512"
                    xml:space="preserve"
                  >
                    <g>
                      <g>
                        <path
                          d="M256,0C114.837,0,0,114.843,0,256s114.837,256,256,256s256-114.843,256-256S397.163,0,256,0z M376.239,227.501
                 L257.348,346.391c-13.043,13.043-34.174,13.044-47.218,0l-68.804-68.804c-13.044-13.038-13.044-34.179,0-47.218
                 c13.044-13.044,34.174-13.044,47.218,0l45.195,45.19l95.282-95.278c13.044-13.044,34.174-13.044,47.218,0
                 C389.283,193.321,389.283,214.462,376.239,227.501z"
                        />
                      </g>
                    </g>
                  </svg>
                </div>
              </div>
            </div>

            <p
              :class="{'values__value--capitalize' : true , values__value : true , 'values__text' : true , animate__animated : true , animate__fadeInRight : personalInformation.name }"
            
            >
              {{personalInformation.name}}
            </p>
            <p
              :class="{'values__value--capitalize' : true  , values__value : true , 'values__text' : true , animate__animated : true , animate__fadeInRight : personalInformation.surname }"
             
            >
              {{personalInformation.surname}}
            </p>
            <p
              :class="{'values__value' : true , 'values__text' : true , animate__animated : true , animate__fadeInRight : personalInformation.email }"
           
            >
              {{personalInformation.email}}
            </p>
            <p
              :class="{values__value : true , 'values__text' : true , animate__animated : true , animate__fadeInRight : personalInformation.phone }"
          
            >
             {{personalInformation.phone}}
            </p>
          </div>
          <div>
            <div
              class="values__titleContainer"
            >
              <h2
                class="values__text values__title"
                
              >
                Pago
              </h2>
              <div class="values__readyContainer">
                <div
               
                  :class="{values__circle : true , 'values__circle--ready' : this.turns.completedFields.pay && this.turns.current == 4 }"
                >
                  <svg
                    v-if="this.turns.completedFields.pay"
                   class="values__ready"
                    fill="#000000"
                    height="24px"
                    width="24px"
                    version="1.1"
                    id="Layer_1"
                    xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink"
                    viewBox="0 0 512 512"
                    xml:space="preserve"
                  >
                    <g>
                      <g>
                        <path
                          d="M256,0C114.837,0,0,114.843,0,256s114.837,256,256,256s256-114.843,256-256S397.163,0,256,0z M376.239,227.501
                 L257.348,346.391c-13.043,13.043-34.174,13.044-47.218,0l-68.804-68.804c-13.044-13.038-13.044-34.179,0-47.218
                 c13.044-13.044,34.174-13.044,47.218,0l45.195,45.19l95.282-95.278c13.044-13.044,34.174-13.044,47.218,0
                 C389.283,193.321,389.283,214.462,376.239,227.501z"
                        />
                      </g>
                    </g>
                  </svg>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="form">

        
          <div


            class="form__backButtonContainer"
           
          >
            <el-button
            class="form__btnPageBack"

              v-if="(turns.current !== 1)"
              @click="back(turns.current)"
            >
              <svg
                width="16px"
                height="16px"
                viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg"
              >
                <title />

                <g id="Complete">
                  <g id="F-Chevron">
                    <polyline
                      fill="none"
                      id="Left"
                      points="15.5 5 8.5 12 15.5 19"
                      stroke="#000"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                    />
                  </g>
                </g></svg
            ></el-button>
            <h2 >{{title}}</h2>
          </div>
          <div class="form__pageContent" >
            <custom-turn
              :modality="valueModality"
              :meeting="valueMeeting"
              :errors="errors"
              :options-modality="optionsModality"
              :options-motives="optionsMotives"
              @value-change="valueChange"
              v-if="turns.turn"
              :loading="loading"
           <?php  
            if (isset($_GET['id'])) {
              echo ':coupon = "' . "'" . $_GET['id'] . "'" .'"'; 
            }
              ?>
            ></custom-turn>

            <div v-if="turns.calendar">
              <div>
                <calendar
              
                  :date-selected="date"
                  @selected="selectDate"
                  @change-month="changeMonth"
                  :loading="loading"
                  :eventos="events"
                  @mounted-calendar="initialCalendar"
                ></calendar>
                <custom-schedule
                  v-if="showSchedule"
                  :date="date"
                  :turns-available="turnsAvailable"
                  @selected-schedule="selectSchedule"
                
                ></-personalizado>
              </div>
            </div>

            <user-form
              :errors="errors"
              @value-change="valueChange"
              v-if="turns.information"
              :name="valueName"
              :surname="valueSurname"
              :email="valueMail"
              :area="valueArea"
              :phone="valuePhone"
              :loading="loading"
            ></user-form>
            <confirm-payment
              v-if="turns.confirmPayment"
              :modality="valueModality"
              :meeting="valueMeeting"
              :options-motives="optionsMotives"
              :loading="loading"
            ></confirm-payment>
          </div>
          <div
         
            class="form__nextButtonContainer"
          >
            <button
              @click="next(turns.current)"
              :class="{'form__btnNext--disabled' : (turns.current == 2 && !valueSchedule) || loading  , 'form__btnNext' : true}"
            >
              Continuar
            </button>

          </div>
        </div>
      </section>
    </div>

    <section
    class="copyright"
     
    >
      <p   class="copyright__text">
        Copyright © 2023 [INSERTE NOMBRE]
      </p>
    </section>

    <script>
      const wsap = document.getElementsByClassName("logoWsap")[0];
      wsap.addEventListener("click", (e) => {
        window.open("http://www.google.com");
      });
    </script>
  </body>
</html>
