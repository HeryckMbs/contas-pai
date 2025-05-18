<template>
  <div class="">

    <v-row>
      <v-col cols="6">
        <div class="">
          <div class="data-card-field">
            <v-text-field class="" :label="$t('cardForm.cardNumber')" 
            :append-inner-icon="isCardNumberMasked ? 'mdi-eye-off' : 'mdi-eye' "
            @click:append-inner="toggleMask"

            type="tel" :id="fields.cardNumber"
              v-model="formData.cardNumber" @input="changeNumber" @focus="focusCardNumber" @blur="blurCardNumber"
              :maxlength="cardNumberMaxLength" data-card-field autocomplete="off" outlined></v-text-field>

       
          </div>

          <div class="data-card-field">
            <v-text-field class="" label="Nome do Cartão"  v-letter-only
              v-model="formData.cardNameTitle" data-card-field autocomplete="off"
              outlined></v-text-field>
          </div>

          <div class="data-card-field">
            <v-text-field class="" :id="fields.cardName" :label="$t('cardForm.cardName')" v-letter-only
              v-model="formData.cardName" data-card-field autocomplete="off" outlined></v-text-field>
          </div>
          <v-row>
            <v-col cols="4">
              <v-select class="data-card-field" :items="months" variant="outlined" :label="$t('cardForm.month')"
                v-model="formData.cardMonth" :id="fields.cardMonth" @change="changeMonth" item-title="text"
                item-value="value" dense outlined data-card-field></v-select>


            </v-col>
            <v-col cols="4">
              <v-select class="data-card-field" :items="years" variant="outlined" :label="$t('cardForm.year')"
                v-model="formData.cardYear" :id="fields.cardYear" @change="changeYear" dense outlined
                data-card-field></v-select> 
            </v-col>
            <v-col cols="4">
              <div class="data-card-field">
                <v-text-field :label="$t('cardForm.CVV')" type="tel" v-model="formData.cardCvv" :id="fields.cardCvv"
                maxlength="4" class="data-card-field" @input="changeCvv" autocomplete="off" outlined></v-text-field>
              </div>
          
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="12">
              <div class="">
                <v-text-field class="" label="Limite" :id="fields.cardLimit" v-letter-only type="number"
                  v-model="formData.cardLimit" max="1000000000" data-card-field autocomplete="off"
                  outlined></v-text-field>
              </div>
    
            </v-col>
          </v-row>

        </div>

      </v-col>
      <v-col   cols="6">

        <Card    :fields="fields" :labels="formData" :isCardNumberMasked="isCardNumberMasked"
          :randomBackgrounds="randomBackgrounds" :backgroundImage="backgroundImage" />
      </v-col>
    </v-row>


  </div>
</template>

<script>
import Card from '@/components/Card'
export default {
  name: 'CardForm',
  directives: {
    'number-only': {
      bind (el) {
        function checkValue (event) {
          event.target.value = event.target.value.replace(/[^0-9]/g, '')
          if (event.charCode >= 48 && event.charCode <= 57) {
            return true
          }
          event.preventDefault()
        }
        el.addEventListener('keypress', checkValue)
      }
    },
    'letter-only': {
      bind (el) {
        function checkValue (event) {
          if (event.charCode >= 48 && event.charCode <= 57) {
            event.preventDefault()
          }
          return true
        }
        el.addEventListener('keypress', checkValue)
      }
    }
  },
  props: {
    formData: {
      type: Object,
      default: () => {
        return {
          cardName: '',
          cardNumber: '',
          cardNumberNotMask: '',
          cardMonth: '',
          cardYear: '',
          cardCvv: '',
          cardNameTitle: ''
        }
      }
    },
    backgroundImage: [String, Object],
    randomBackgrounds: {
      type: Boolean,
      default: true
    }
  },
  components: {
    Card
  },
  data () {
    return {
      fields: {
        cardNumber: 'v-card-number',
        cardName: 'v-card-name',
        cardMonth: 'v-card-month',
        cardYear: 'v-card-year',
        cardCvv: 'v-card-cvv',
        cardLimit: 'v-card-limit'
      },
      minCardYear: new Date().getFullYear(),
      isCardNumberMasked: true,
      mainCardNumber: this.cardNumber,
      cardNumberMaxLength: 19,
      months: [],
      years: []
    }
  },
  computed: {
    minCardMonth() {
      if (this.formData.cardYear === this.minCardYear) return new Date().getMonth() + 1
      return 1
    }
  },
  watch: {
    cardYear() {
      if (this.formData.cardMonth < this.minCardMonth) {
        this.formData.cardMonth = ''
      }
    },
    formData(newValue,oldValue){
      
      if(newValue.cardNumber != ''){
        this.isCardNumberMasked = false;
        this.toggleMask();
      }
    }
  },
  mounted() {
    this.years = Array.from({ length: 12 }, (v, k) => this.minCardYear + k)
    this.months = Array.from({ length: 12 }, (v, k) => ({
      text: this.generateMonthValue(k + 1),
      value: k < 9 ? `0${k + 1}` : `${k + 1}`
    }));

    this.maskCardNumber()
  },
  methods: {
    generateMonthValue (n) {
      return n < 10 ? `0${n}` : n
    },
    changeName (e) {
      this.formData.cardName = e.target.value
      this.$emit('input-card-name', this.formData.cardName)
    },
    changeNumber (e) {
      this.formData.cardNumber = e.target.value
      let value = this.formData.cardNumber.replace(/\D/g, '')
      // american express, 15 digits
      if ((/^3[47]\d{0,13}$/).test(value)) {
        this.formData.cardNumber = value.replace(/(\d{4})/, '$1 ').replace(/(\d{4}) (\d{6})/, '$1 $2 ')
        this.cardNumberMaxLength = 17
      } else if ((/^3(?:0[0-5]|[68]\d)\d{0,11}$/).test(value)) { // diner's club, 14 digits
        this.formData.cardNumber = value.replace(/(\d{4})/, '$1 ').replace(/(\d{4}) (\d{6})/, '$1 $2 ')
        this.cardNumberMaxLength = 16
      } else if ((/^\d{0,16}$/).test(value)) { // regular cc number, 16 digits
        this.formData.cardNumber = value.replace(/(\d{4})/, '$1 ').replace(/(\d{4}) (\d{4})/, '$1 $2 ').replace(/(\d{4}) (\d{4}) (\d{4})/, '$1 $2 $3 ')
        this.cardNumberMaxLength = 19
      }
      // eslint-disable-next-line eqeqeq
      if (e.inputType == 'deleteContentBackward') {
        let lastChar = this.formData.cardNumber.substring(this.formData.cardNumber.length, this.formData.cardNumber.length - 1)
        // eslint-disable-next-line eqeqeq
        if (lastChar == ' ') { this.formData.cardNumber = this.formData.cardNumber.substring(0, this.formData.cardNumber.length - 1) }
      }
      this.$emit('input-card-number', this.formData.cardNumber)
    },
    changeMonth () {
      this.$emit('input-card-month', this.formData.cardMonth)
    },
    changeYear () {
      this.$emit('input-card-year', this.formData.cardYear)
    },
    changeCvv (e) {
      this.formData.cardCvv = e.target.value
      this.$emit('input-card-cvv', this.formData.cardCvv)
    },
    invaildCard () {
      let number = this.formData.cardNumberNotMask.replace(/ /g, '')
      var sum = 0
      for (var i = 0; i < number.length; i++) {
        var intVal = parseInt(number.substr(i, 1))
        if (i % 2 === 0) {
          intVal *= 2
          if (intVal > 9) {
            intVal = 1 + (intVal % 10)
          }
        }
        sum += intVal
      }
      if (sum % 10 !== 0) {
        alert(this.$t('cardForm.invalidCardNumber'))
      }
    },
    blurCardNumber () {
      if (this.isCardNumberMasked) {
        this.maskCardNumber()
      }
    },
    maskCardNumber () {
      this.formData.cardNumberNotMask = this.formData.cardNumber
      this.mainCardNumber = this.formData.cardNumber
      let arr = this.formData.cardNumber.split('')
      arr.forEach((element, index) => {
        if (index > 4 && index < 14 && element.trim() !== '') {
          arr[index] = '*'
        }
      })
      this.formData.cardNumber = arr.join('')
    },
    unMaskCardNumber () {
      this.formData.cardNumber = this.mainCardNumber
    },
    focusCardNumber () {
      this.unMaskCardNumber()
    },
    toggleMask () {
      this.isCardNumberMasked = !this.isCardNumberMasked
      if (this.isCardNumberMasked) {
        this.maskCardNumber()
      } else {
        this.unMaskCardNumber()
      }
    }
  }
}
</script>
