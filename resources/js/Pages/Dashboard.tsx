import Main from '@/Layouts/Main'
import { PageProps, User } from '@/types'
import Category from '@/types/category'
import Product from '@/types/product'
import { Link } from '@inertiajs/react'
import { Swiper, SwiperSlide } from 'swiper/react'
import NoImage from '@/Images/no-image.png'
import 'swiper/css';
import 'swiper/css/pagination';
import { useEffect, useState } from 'react'
import EasyMDE from 'easymde'
import Markdown from 'react-markdown'
import { formatCurrency } from '@/Helpers'
import Image from '@/Components/Image'
import { Autoplay, Navigation, Pagination } from 'swiper/modules'
import Heros from '@/Components/Heros'
import Post from '@/types/post'

interface Props extends PageProps {
  posts?: Post[]
  categories?: (Category & {
    products?: Product[]
  })[]
  products?: Product[]
}

const DashboardPage = (props: Props) => {
  const [postsLimit, setPostsLimit] = useState(true)

  return (
    <Main user={props.auth.user}>
      {/* Heros */}
      {props.products?.length ? (
        <Heros products={props.products} />
      ) : <>No Products Available</>}

      {/* All Products By Categories */}
      <section id='categories' className='p-3'>
        <h1 className='text-xl font-bold mb-3'>
          Our products
        </h1>
        <div className="flex flex-col gap-3">
          {props.categories?.map(c => (
            <div className="collapse collapse-arrow bg-base-200" key={c.id}>
              <input type="checkbox" />
              <h2 className="collapse-title text-xl font-bold">
                {c.name}
              </h2>
              <div className="collapse-content flex-col flex gap-3">
                {c.products?.length ?
                  c.products.map(p => (
                    <div className='bg-base-300 p-3 rounded-xl' key={p.id}>
                      <Link href={`/products/${p.slug}`} target='_blank'>
                        <h3 className='font-semibold underline text-lg'>
                          {p.name}
                        </h3>
                      </Link>
                      <div className='line-clamp-2 text-xs'>
                        <Markdown>
                          {p.description}
                        </Markdown>
                      </div>
                    </div>
                  ))
                  : <>No Products Available in This Category</>}
              </div>
            </div>
          ))}
        </div>
      </section>

      {/* All Posts */}
      <section id='posts' className='p-3'>
        <h1 className='text-xl font-bold mb-3'>
          Our Blog
        </h1>
        <div className="flex flex-col gap-3">
          {props.posts?.slice(0, postsLimit ? 3 : props.posts.length + 1).map(p => (
            <div className="bg-base-200 p-3 rounded-xl flex flex-col" key={p.id}>
              <Link href={`/posts/${p.slug}`} className='link-hover'>
                <h2 className='font-bold text-xl'>{p.title}</h2>
              </Link>
              <div className='line-clamp-2 text-xs'>
                <Markdown>
                  {p.content}
                </Markdown>
              </div>
              <Link href={`/posts/${p.slug}`} className="btn btn-sm btn-neutral w-max self-end">
                Show More
              </Link>
            </div>
          ))}
          <button className='btn btn-neutral btn-sm w-max mx-auto' onClick={() => setPostsLimit(!postsLimit)}>
            {postsLimit ? 'Show More' : 'Show Less'}
          </button>
        </div>
      </section>
    </Main >
  )
}


export default DashboardPage
