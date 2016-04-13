class CreateSemesters < ActiveRecord::Migration
  def change
    create_table :semesters do |t|
	t.belongs_to :HoursUpdate
      t.string :name
      t.Date :startDate
      t.Date :endDate

      t.timestamps null: false
    end
  end
end
