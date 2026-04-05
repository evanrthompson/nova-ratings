import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('index-nova-ratings', IndexField)
  app.component('detail-nova-ratings', DetailField)
  app.component('form-nova-ratings', FormField)
})
