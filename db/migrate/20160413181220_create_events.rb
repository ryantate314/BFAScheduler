class CreateEvents < ActiveRecord::Migration
  def change
    create_table :events do |t|
	t.belongs_to :EventWorkerPosition
      t.int :id
      t.string :name
      t.DateTime :startTime

      t.timestamps null: false
    end
  end
end
