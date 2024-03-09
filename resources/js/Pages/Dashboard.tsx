import Main from '@/Layouts/Main'
import { PageProps } from '@/types'
import { Link } from '@inertiajs/react'

interface Props extends PageProps {

}

const Dashboard = (props: Props) => {
  // console.log('asfd')
  return (
    <Main user={props.auth.user}>
      <Link href='/test'>
        change to test
      </Link>
    </Main>
  )
}


export default Dashboard
